<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Loan;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Form\MemberLoanType;

/**
 * MemberLoan controller.
 *
 * @Route("/memberloan")
 */
class MemberLoanController extends Controller
{
  /**
   * Lists all MemberLoan entities.
   *
   * @Route("/", name="memberloan_index")
   * @Method("GET")
   */
  public function indexAction(Request $request)
  {
    $em = $this->getDoctrine()->getManager();

    if ($request->query->get('profileId')) {
      $memberLoans = $em->getRepository('AppBundle:Loan')->findAll($request->query->get('profileId'));
    } else {
      $memberLoans = $em->getRepository('AppBundle:Loan')->findAll();
    }

    return $this->render('memberloan/index.html.twig', array(
      'memberLoans' => $memberLoans,
    ));
  }

  /**
   * Creates a new MemberLoan entity.
   *
   * @Route("/new", name="memberloan_new")
   * @Method({"GET", "POST"})
   */
  public function newAction(Request $request)
  {
    $loan = new Loan();
    $form = $this->get('form.factory')->create('AppBundle\Form\MemberLoanType', $loan);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
      $profile = $this->get('security.token_storage')->getToken()->getUser()->getProfile();
      $loan->setProfile($profile);
      $em = $this->getDoctrine()->getManager();
      $em->persist($loan);
      $em->flush();

      return $this->redirectToRoute('memberloan_show', array('id' => $loan->getId()));
    }

    return $this->render('memberloan/new.html.twig', array(
      'memberLoan' => $loan,
      'form' => $form->createView(),
    ));
  }

  /**
   * Finds and displays a MemberLoan entity.
   *
   * @Route("/{id}", name="memberloan_show")
   * @Method("GET")
   */
  public function showAction(Loan $loan)
  {
    $deleteForm = $this->createDeleteForm($loan);

    return $this->render('memberloan/show.html.twig', array(
      'memberLoan' => $loan,
      'delete_form' => $deleteForm->createView(),
    ));
  }

  /**
   * Displays a form to edit an existing MemberLoan entity.
   *
   * @Route("/{id}/edit", name="memberloan_edit")
   * @Method({"GET", "POST"})
   * @param Request $request
   * @param Loan $loan
   * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
   */
  public function editAction(Request $request, Loan $loan)
  {
    $deleteForm = $this->createDeleteForm($loan);
    $editForm = $this->createForm('AppBundle\Form\MemberLoanType', $loan);
    $editForm->handleRequest($request);

    if ($editForm->isSubmitted() && $editForm->isValid()) {
      if ($this->isGranted('ROLE_ADMIN') && $loan->getApprovalStatus() === 'Approved') {
        $loan->setDateIssued(new \DateTime());
        $loan->setIssuedBy($this->getUser()->getProfile()->getId());
      }

      $em = $this->getDoctrine()->getManager();
      $em->persist($loan);
      $em->flush();

      return $this->redirectToRoute('memberloan_show', array('id' => $loan->getId()));
    }

    return $this->render('memberloan/edit.html.twig', array(
      'memberLoan' => $loan,
      'edit_form' => $editForm->createView(),
      'delete_form' => $deleteForm->createView(),
    ));
  }

  /**
   * @Route("/{loanId}/payment", name="loan_payment")
   *
   * @param Request $request
   * @return \Symfony\Component\HttpFoundation\Response
   */
  public function paymentsAction(Request $request)
  {
    $loanId = $request->query->get('loanId');
    $em = $this->getDoctrine()->getManager();

    $payments = $em->getRepository('AppBundle:Payment')->findBy(['loan' => $loanId]);

    return $this->render('payment/index.html.twig', array(
      'payments' => $payments,
    ));
  }

  /**
   * Deletes a MemberLoan entity.
   *
   * @Route("/{id}", name="memberloan_delete")
   * @Method("DELETE")
   */
  public function deleteAction(Request $request, Loan $loan)
  {
    $form = $this->createDeleteForm($loan);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
      $em = $this->getDoctrine()->getManager();
      $em->remove($loan);
      $em->flush();
    }

    return $this->redirectToRoute('memberloan_index');
  }

  /**
   * Creates a form to delete a MemberLoan entity.
   *
   * @param MemberLoan $loan The MemberLoan entity
   *
   * @return \Symfony\Component\Form\Form The form
   */
  private function createDeleteForm(Loan $loan)
  {
    return $this->createFormBuilder()
      ->setAction($this->generateUrl('memberloan_delete', array('id' => $loan->getId())))
      ->setMethod('DELETE')
      ->getForm();
  }
}
