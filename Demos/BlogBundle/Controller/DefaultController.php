<?php

namespace Demos\BlogBundle\Controller;

use Demos\BlogBundle\Entity\Post;
use Symfony\Component\HttpFoundation\Response;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class DefaultController extends Controller
{
    /**
     * @Route("/hello/{name}")
     * @Template()
     */
    public function indexAction($name)
    {
        return array('name' => $name);
    }

    /**
     * @Route("/create")
     */
    public function createAction()
    {
        $post = new Post();
        $post->setTitle('Demo Blog');
        $post->setBody('Hello Symfony 2');
        $post->setCreatedDate(new \DateTime("now"));
        $post->setUpdatedDate(new \DateTime('now'));

        $em = $this->getDoctrine()->getEntityManager();
        $em->persist($post);
        $em->flush();

        return new Response('Created product id ' . $post->getId());
    }

    /**
     * @Route("/show/{id}")
     * @Template()
     */
    public function showAction($id)
    {
        $post = $this->getDoctrine()
                ->getRepository('DemosBlogBundle:Post')
                ->find($id);

        if (!$post) {
            throw $this->createNotFoundException('Страница не найдена!');
        }

        return array('post' => $post);
    }

}
