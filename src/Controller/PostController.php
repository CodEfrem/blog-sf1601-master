<?php

namespace App\Controller;

use App\Entity\Post;
use App\Form\PostType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PostController extends AbstractController
{
    #[Route('/posts/{slug}/edit', name: 'post_edit')]
    public function edit(
        Request $request,
        Post $post,
        EntityManagerInterface $em
    ): Response {
        // Edit form + process
        $form = $this->createForm(PostType::class, $post);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Handle image upload if needed
            // You can add your image handling logic here

            $em->flush();

            // Redirect to the post page
            return $this->redirectToRoute('post_show', ['slug' => $post->getSlug()]);
        }

        // Return the view
        return $this->render('post/edit.html.twig', [
            'post' => $post,
            'editForm' => $form->createView(),
        ]);
    }

    #[Route('/posts/{slug}', name: 'post_show')]
    public function show(Post $post): Response
    {
        // TODO: Add logic to handle displaying a single post
        // You can customize this method based on your needs

        return $this->render('post/show.html.twig', [
            'post' => $post,
        ]);
    }
}
