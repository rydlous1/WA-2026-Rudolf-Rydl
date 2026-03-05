<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <div>
        <div>
            <h2>Přidat novou knihu </h2>
            <p>Vyplňte údaje a uložte knihu do databáze.</p>
        </div>

        <div>
            <form action="">
                <div>
                    <div>
                        <label for="title">Název knihy <span>*</span></label>
                        <input type="text" id="title" name="title" required="required">
                    </div>

                    <div>
                        <label for="author">Autor<span>*</span></label>
                        <input type="text" id="author" name="author" required="required">
                    </div>

                    <div>
                        <label for="category">Kategorie</label>
                        <input type="text" id="category" name="category" required="required">
                    </div>

                    <div>
                        <label for="subcategory">Podkategorie</label>
                        <input type="text" id="subcategory" name="subcategory" required="required">
                    </div>

                    <div>
                        <label for="year">Název knihy <span>*</span></label>
                        <input type="number" id="year" name="year" required="required">
                    </div>

                    <div>
                        <button type="submit">Uložit knihu do DB</button>
                    </div>
                </div>
        </div>
    
</body>
</html>