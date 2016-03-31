<?php

namespace AppBundle\Controller;

use Symfony\Component\Form\FormEvents;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\Payment;
use AppBundle\Form\PaymentType;

/**
 * Payment controller.
 *
 * @Route("/loan/{loanId}/payment")
 */
class PaymentController extends Controller
{
  /**
   * Lists all Payment entities.
   *
   * @Route("/", name="payment_index")
   * @Method("GET")
   */
  public function indexAction(Request $request)
  {
    $loanId = $request->get('loanId');

    $em = $this->getDoctrine()->getManager();

    $loan = $em->getRepository('AppBundle:Loan')->find($loanId);
    $payments = $loan->getPayments();

    $total = 0;
    for ($i=0;$i<=$payments->count(); $i++) {
      if ($payments->get($i)) {
        $total += $payments->get($i)->getAmountPaid();
      }
    }

    $totalAmountPayable = ($loan->getAmount() * $loan->getInterestRate()/100 * $loan->getDuration()) + $loan->getAmount();

    $balance = $totalAmountPayable - $total;

    return $this->render('payment/index.html.twig', array(
      'loan' => $loan,
      'payments' => $payments,
      'balance' => $balance
    ));
  }

  /**
   * Creates a new Payment entity.
   *
   * @Route("/new", name="payment_new")
   * @Method({"GET", "POST"})
   */
  public function newAction(Request $request)
  {
    $em = $this->getDoctrine()->getManager();

    $payment = new Payment();

    $loan =  $em->getRepository('AppBundle:Loan')->find($request->get('loanId'));
    $profileId = $loan->getProfile()->getId();
    $profile = $em->getPartialReference('AppBundle\Entity\Profile', $profileId);
    $payment->setLoan($loan);
    $payment->setProfile($profile);
    $form = $this->createForm('AppBundle\Form\PaymentType', $payment);
    $form->handleRequest($request);

    $payment->setDateOfPayment(new \DateTime());

    if ($form->isSubmitted() && $form->isValid()) {
      $em->persist($payment);
      $em->flush();

      return $this->redirectToRoute('payment_show', array('id' => $payment->getId(), 'loanId' => $request->get('loanId')));
    }

    return $this->render('payment/new.html.twig', array(
      'payment' => $payment,
      'form' => $form->createView(),
    ));
  }

  /**
   * Finds and displays a Payment entity.
   *
   * @Route("/{id}", name="payment_show")
   * @Method("GET")
   */
  public function showAction(Payment $payment, Request $request)
  {
    $deleteForm = $this->createDeleteForm($payment, $request);

    return $this->render('payment/show.html.twig', array(
      'payment' => $payment,
      'delete_form' => $deleteForm->createView(),
    ));
  }

  /**
   * Displays a form to edit an existing Payment entity.
   *
   * @Route("/{id}/edit", name="payment_edit")
   * @Method({"GET", "POST"})
   */
  public function editAction(Request $request, Payment $payment)
  {
    $deleteForm = $this->createDeleteForm($payment, $request);
    $editForm = $this->createForm('AppBundle\Form\PaymentType', $payment);
    $editForm->handleRequest($request);

    if ($editForm->isSubmitted() && $editForm->isValid()) {
      $em = $this->getDoctrine()->getManager();
      $em->persist($payment);
      $em->flush();

      return $this->redirectToRoute('payment_edit', array('id' => $payment->getId()));
    }

    return $this->render('payment/edit.html.twig', array(
      'payment' => $payment,
      'edit_form' => $editForm->createView(),
      'delete_form' => $deleteForm->createView(),
    ));
  }

  /**
   * Deletes a Payment entity.
   *
   * @Route("/{id}", name="payment_delete")
   * @Method("DELETE")
   */
  public function deleteAction(Request $request, Payment $payment)
  {
    $form = $this->createDeleteForm($payment, $request);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
      $em = $this->getDoctrine()->getManager();
      $em->remove($payment);
      $em->flush();
    }

    return $this->redirectToRoute('payment_index');
  }

  /**
   * Creates a form to delete a Payment entity.
   *
   * @param Payment $payment The Payment entity
   *
   * @return \Symfony\Component\Form\Form The form
   */
  private function createDeleteForm(Payment $payment, $request)
  {
    return $this->createFormBuilder()
      ->setAction($this->generateUrl('payment_delete', array('id' => $payment->getId(), 'loanId' => $request->get('loanId'))))
      ->setMethod('DELETE')
      ->getForm();
  }
}
