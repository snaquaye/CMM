<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\Profile;
use AppBundle\Form\ProfileType;

/**
 * Profile controller.
 *
 * @Route("/profile")
 */
class ProfileController extends Controller
{
  /**
   * Lists all Profile entities.
   *
   * @Route("/", name="profile_index")
   * @Method("GET")
   */
  public function indexAction()
  {
    $em = $this->getDoctrine()->getManager();

    $profiles = $em->getRepository('AppBundle:Profile')->findAll();

    return $this->render('profile/index.html.twig', array(
      'profiles' => $profiles,
    ));
  }

  /**
   * Lists all loans for a specific member
   *
   * @Route("/{profileId}/loan", name="profile_loan")
   * @param Request $request
   * @return \Symfony\Component\HttpFoundation\Response
   */
  public function memberLoanAction(Request $request)
  {
    $em = $this->getDoctrine()->getManager();

    $profileId = $request->get('profileId');

    $loans = $em->getRepository('AppBundle:Loan')->findBy(['profile' => $profileId]);

    return $this->render('memberloan/index.html.twig', array(
      'memberLoans' => $loans,
    ));
  }

  /**
   * Creates a new Profile entity.
   *
   * @Route("/new", name="profile_new")
   * @Method({"GET", "POST"})
   */
  public function newAction(Request $request)
  {
    $profile = new Profile();
    $form = $this->createForm('AppBundle\Form\ProfileType', $profile);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
      $em = $this->getDoctrine()->getManager();
      $em->persist($profile);
      $em->flush();

      return $this->redirectToRoute('profile_show', array('id' => $profile->getId()));
    }

    return $this->render('profile/new.html.twig', array(
      'profile' => $profile,
      'form' => $form->createView(),
    ));
  }

  /**
   * Finds and displays a Profile entity.
   *
   * @Route("/{id}", name="profile_show")
   * @Method("GET")
   */
  public function showAction(Profile $profile)
  {
    $deleteForm = $this->createDeleteForm($profile);

    return $this->render('profile/show.html.twig', array(
      'profile' => $profile,
      'delete_form' => $deleteForm->createView(),
    ));
  }

  /**
   * Displays a form to edit an existing Profile entity.
   *
   * @Route("/{id}/edit", name="profile_edit")
   * @Method({"GET", "POST"})
   */
  public function editAction(Request $request, Profile $profile)
  {
    $deleteForm = $this->createDeleteForm($profile);
    $editForm = $this->createForm('AppBundle\Form\ProfileType', $profile);
    $editForm->handleRequest($request);

    if ($editForm->isSubmitted() && $editForm->isValid()) {
      $em = $this->getDoctrine()->getManager();
      $em->persist($profile);
      $em->flush();

      return $this->redirectToRoute('profile_show', array('id' => $profile->getId()));
    }

    return $this->render('profile/edit.html.twig', array(
      'profile' => $profile,
      'edit_form' => $editForm->createView(),
      'delete_form' => $deleteForm->createView(),
    ));
  }

  /**
   * Deletes a Profile entity.
   *
   * @Route("/{id}", name="profile_delete")
   * @Method("DELETE")
   */
  public function deleteAction(Request $request, Profile $profile)
  {
    $form = $this->createDeleteForm($profile);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
      $em = $this->getDoctrine()->getManager();
      $em->remove($profile);
      $em->flush();
    }

    return $this->redirectToRoute('profile_index');
  }

  /**
   * Creates a form to delete a Profile entity.
   *
   * @param Profile $profile The Profile entity
   *
   * @return \Symfony\Component\Form\Form The form
   */
  private function createDeleteForm(Profile $profile)
  {
    return $this->createFormBuilder()
      ->setAction($this->generateUrl('profile_delete', array('id' => $profile->getId())))
      ->setMethod('DELETE')
      ->getForm();
  }
}
