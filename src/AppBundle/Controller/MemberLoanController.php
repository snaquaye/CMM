<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\MemberLoan;
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
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $memberLoans = $em->getRepository('Loan.php')->findAll();

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
        $memberLoan = new MemberLoan();
        $form = $this->createForm('AppBundle\Form\MemberLoanType', $memberLoan);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($memberLoan);
            $em->flush();

            return $this->redirectToRoute('memberloan_show', array('id' => $memberLoan->getId()));
        }

        return $this->render('memberloan/new.html.twig', array(
            'memberLoan' => $memberLoan,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a MemberLoan entity.
     *
     * @Route("/{id}", name="memberloan_show")
     * @Method("GET")
     */
    public function showAction(MemberLoan $memberLoan)
    {
        $deleteForm = $this->createDeleteForm($memberLoan);

        return $this->render('memberloan/show.html.twig', array(
            'memberLoan' => $memberLoan,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing MemberLoan entity.
     *
     * @Route("/{id}/edit", name="memberloan_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, MemberLoan $memberLoan)
    {
        $deleteForm = $this->createDeleteForm($memberLoan);
        $editForm = $this->createForm('AppBundle\Form\MemberLoanType', $memberLoan);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($memberLoan);
            $em->flush();

            return $this->redirectToRoute('memberloan_edit', array('id' => $memberLoan->getId()));
        }

        return $this->render('memberloan/edit.html.twig', array(
            'memberLoan' => $memberLoan,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a MemberLoan entity.
     *
     * @Route("/{id}", name="memberloan_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, MemberLoan $memberLoan)
    {
        $form = $this->createDeleteForm($memberLoan);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($memberLoan);
            $em->flush();
        }

        return $this->redirectToRoute('memberloan_index');
    }

    /**
     * Creates a form to delete a MemberLoan entity.
     *
     * @param MemberLoan $memberLoan The MemberLoan entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(MemberLoan $memberLoan)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('memberloan_delete', array('id' => $memberLoan->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
