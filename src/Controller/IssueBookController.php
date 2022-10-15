<?php

namespace App\Controller;

use App\Entity\IssueBook;
use App\Form\IssueBookType;
use App\Repository\IssueBookRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/issue/book")
 */
class IssueBookController extends AbstractController
{
    /**
     * @Route("/", name="app_issue_book_index", methods={"GET"})
     */
    public function index(IssueBookRepository $issueBookRepository): Response
    {
        return $this->render('issue_book/index.html.twig', [
            'issue_books' => $issueBookRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="app_issue_book_new", methods={"GET", "POST"})
     */
    public function new(Request $request, IssueBookRepository $issueBookRepository): Response
    {
        $issueBook = new IssueBook();
        $form = $this->createForm(IssueBookType::class, $issueBook);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $issueBookRepository->add($issueBook, true);

            return $this->redirectToRoute('app_issue_book_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('issue_book/new.html.twig', [
            'issue_book' => $issueBook,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_issue_book_show", methods={"GET"})
     */
    public function show(IssueBook $issueBook): Response
    {
        return $this->render('issue_book/show.html.twig', [
            'issue_book' => $issueBook,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_issue_book_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, IssueBook $issueBook, IssueBookRepository $issueBookRepository): Response
    {
        $form = $this->createForm(IssueBookType::class, $issueBook);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $issueBookRepository->add($issueBook, true);

            return $this->redirectToRoute('app_issue_book_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('issue_book/edit.html.twig', [
            'issue_book' => $issueBook,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_issue_book_delete", methods={"POST"})
     */
    public function delete(Request $request, IssueBook $issueBook, IssueBookRepository $issueBookRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$issueBook->getId(), $request->request->get('_token'))) {
            $issueBookRepository->remove($issueBook, true);
        }

        return $this->redirectToRoute('app_issue_book_index', [], Response::HTTP_SEE_OTHER);
    }
}
