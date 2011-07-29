<?php

namespace Demos\BlogBundle\Controller;

use Demos\BlogBundle\Entity\Blog;
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
        $blog = new Blog();
        $blog->setTitle('Demo Blog');
        $blog->setBody('Hello Symfony 2');
        $blog->setCreatedDate(new \DateTime("now"));
        $blog->setUpdatedDate(new \DateTime('now'));

        $em = $this->getDoctrine()->getEntityManager();
        $em->persist($blog);
        $em->flush();

        return new Response('Created product id ' . $blog->getId());
    }

    /**
     * @Route("/show/{id}")
     */
    public function showAction($id)
    {
        $blog = $this->getDoctrine()->getRepository('DemosBlogBundle:Blog')->find($id);

        if (!$blog) {
            throw $this->createNotFoundException('Страница не найдена!');
        }

        $html = <<<HTML
        <h1>{$blog->getTitle()}</h1>

        <p>{$blog->getBody()}</p>

        <hr/>
        <small>Запись создана {$blog->getCreatedDate()->format("Y-m-d H:i:s")}</small>
HTML;

        return new Response($html);
    }

}
