<?php

namespace App\Controller;

use App\Entity\Book;
use App\Form\BookType;
use App\Repository\BookRepository;
use App\Repository\CategoryRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/book")
 */
class BookController extends AbstractController
{
    /**
     * @Route("/{pageId}", name="app_book_index", methods={"GET"})
     */
    public function index(Request $request, BookRepository $bookRepository,
                          int $pageId = 1): Response
    {
        $minPrice = $request->query->get('minPrice');
        $maxPrice = $request->query->get('maxPrice');
        $cat = $request->query->get('category');
//        $book = $bookRepository->findAllPriceRange($minPrice, $maxPrice, $cat);
        if(!(is_null($cat)||empty($cat))){
            $selectedCat=$cat;
        }else
            $selectedCat='';
        $temQuery = $bookRepository->findAllPriceRange($minPrice, $maxPrice, $cat);
        $pageSize = 2;
        $paginator = new Paginator($temQuery);
        $totalItems = count($paginator);
        $numOfPages = ceil($totalItems/$pageSize);
        $tempQuery = $paginator
            ->getQuery()
            ->setFirstResult($pageSize * ($pageId - 1)) // set the offset
            ->setMaxResults($pageSize); // set the limit
        return $this->render('book/index.html.twig', [
            'books' => $tempQuery->getResult(),
            'selectedCat' => $selectedCat,
//            'categories' => $categoryRepository->findAll(),
            'numOfPages' => $numOfPages,
            'totalItem' => $totalItems
        ]);
//        return $this->render('book/index.html.twig', [
//            'books' => $book,
//            'selectedCat'=>$selectedCat
//        ]);
    }

    /**
     * @Route("/new", name="app_book_new", methods={"GET", "POST"})
     */
    public function new(Request $request, BookRepository $bookRepository): Response
    {
        $book = new Book();
        $form = $this->createForm(BookType::class, $book);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $bookRepository->add($book, true);

            return $this->redirectToRoute('app_book_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('book/new.html.twig', [
            'book' => $book,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_book_show", methods={"GET"})
     */
    public function show(Book $book): Response
    {
        return $this->render('book/show.html.twig', [
            'book' => $book,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_book_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Book $book, BookRepository $bookRepository): Response
    {
        $form = $this->createForm(BookType::class, $book);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $bookRepository->add($book, true);

            return $this->redirectToRoute('app_book_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('book/edit.html.twig', [
            'book' => $book,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_book_delete", methods={"POST"})
     */
    public function delete(Request $request, Book $book, BookRepository $bookRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$book->getId(), $request->request->get('_token'))) {
            $bookRepository->remove($book, true);
        }

        return $this->redirectToRoute('app_book_index', [], Response::HTTP_SEE_OTHER);
    }
}
