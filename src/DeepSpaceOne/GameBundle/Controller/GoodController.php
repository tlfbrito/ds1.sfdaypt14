<?php

namespace DeepSpaceOne\GameBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use DeepSpaceOne\GameBundle\Entity\Good;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotNull;
use Symfony\Component\Validator\Constraints\Range;

/**
 * Good controller.
 *
 * @Route("/goods")
 */
class GoodController extends Controller
{
    /**
     * Lists all Good entities.
     *
     * @Route("/", name="goods")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $goods = $em->getRepository('DeepSpaceOneGameBundle:Good')->findAll();

        return array(
            'goods' => $goods,
        );
    }

    /**
     * Displays a form to create a new Good entity.
     *
     * @Route("/new", name="goods_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $form = $this->createCreateForm();

        return array(
            'form' => $form->createView(),
        );
    }

    /**
     * Creates a new Good entity.
     *
     * @Route("/", name="goods_create")
     * @Method("POST")
     * @Template("DeepSpaceOneGameBundle:Good:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $form = $this->createCreateForm();

        $form->handleRequest($request);

        if ($form->isValid()) {
            $good = new Good();
            $good->setName($form->get('name')->getData());
            $good->setPricePerTon($form->get('price')->getData());

            $em = $this->getDoctrine()->getManager();
            $em->persist($good);
            $em->flush();

            return $this->redirect($this->generateUrl('goods'));
        }

        return array(
            'form' => $form->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Good entity.
     *
     * @Route("/{id}/edit", name="goods_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction(Good $good)
    {
        $deleteForm = $this->createDeleteForm($good);
        $editForm = $this->createEditForm($good);

        return array(
            'good' => $good,
            'delete_form' => $deleteForm->createView(),
            'edit_form' => $editForm->createView(),
        );
    }

    /**
     * Edits an existing Good entity.
     *
     * @Route("/{id}", name="goods_update")
     * @Method("PUT")
     * @Template("DeepSpaceOneGameBundle:Good:edit.html.twig")
     */
    public function updateAction(Request $request, Good $good)
    {
        $deleteForm = $this->createDeleteForm($good);
        $editForm = $this->createEditForm($good);

        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $good->setName($editForm->get('name')->getData());
            $good->setPricePerTon($editForm->get('price')->getData());

            $em = $this->getDoctrine()->getManager();
            $em->flush();

            return $this->redirect($this->generateUrl('goods'));
        }

        return array(
            'good' => $good,
            'delete_form' => $deleteForm->createView(),
            'edit_form' => $editForm->createView(),
        );
    }

    /**
     * Deletes a Good entity.
     *
     * @Route("/{id}", name="goods_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Good $good)
    {
        $form = $this->createDeleteForm($good);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($good);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('goods'));
    }

    /**
     * Creates a preconfigured form builder for editing Good entities.
     *
     * @return \Symfony\Component\Form\FormBuilderInterface The form builder
     */
    private function createGoodFormBuilder()
    {
        return $this->createFormBuilder()
            ->add('name', null, array(
                'constraints' => array(
                    new NotNull(),
                    new Length(array('min' => 2, 'minMessage' => 'Please enter at least 2 characters.')),
                ),
            ))
            ->add('price', 'integer', array(
                'constraints' => array(
                    new NotNull(),
                    new Range(array('min' => 1, 'minMessage' => 'Please enter a value of 1 or more.')),
                ),
            ))
        ;
    }

    /**
     * Creates a form to create a new Good entity.
     *
     * @return \Symfony\Component\Form\FormInterface The form
     */
    private function createCreateForm()
    {
        return $this->createGoodFormBuilder()
            ->setAction($this->generateUrl('goods_create'))
            ->add('create', 'submit')
            ->setData(array(
                'price' => 10,
            ))
            ->getForm();
    }

    /**
     * Creates a form to edit an existing Good entity.
     *
     * @param Good $good The good
     *
     * @return \Symfony\Component\Form\FormInterface The form
     */
    private function createEditForm(Good $good)
    {
        return $this->createGoodFormBuilder()
            ->setAction($this->generateUrl('goods_update', array('id' => $good->getId())))
            ->setMethod('PUT')
            ->add('update', 'submit')
            ->setData(array(
                'name' => $good->getName(),
                'price' => $good->getPricePerTon(),
            ))
            ->getForm();
    }

    /**
     * Creates a form to delete a Good entity by id.
     *
     * @param Good $good The good
     *
     * @return \Symfony\Component\Form\FormInterface The form
     */
    private function createDeleteForm(Good $good)
    {
        return $this->createFormBuilder(null, array('style' => 'none'))
            ->setAction($this->generateUrl('goods_delete', array('id' => $good->getId())))
            ->setMethod('DELETE')
            ->add('delete', 'submit', array('attr' => array('class' => 'btn-danger')))
            ->getForm()
        ;
    }
}
