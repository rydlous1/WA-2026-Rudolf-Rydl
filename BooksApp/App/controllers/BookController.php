<?php


class BookController {
    //výchozí metoda pro zobrazení úvodní stránky
    public function index(){
        // v dalších krocích se zde přidá komunikace s Modelem pro zisk
        //(např. načtení všech uložených knih)


        //Nyní se pouze načte (vloží) připravený soubor s HTML
        require_once '../WA-2026-Rudolf-Rydl/BooksApp/App/views/books/book_list.php';
    }








}