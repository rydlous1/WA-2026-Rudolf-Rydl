<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GGstore - Přidat hru (Prostá verze)</title>
</head>
<body>
    <div>
        <p>
            <a href="<?= BASE_URL ?>/index.php">&larr; Zpět na seznam her</a>
        </p>

        <div>
            <h2>Přidat novou hru</h2>
            <p>Vyplňte údaje a uložte hru do databáze.</p>
        </div>
        
        <div>
            
            <form action="<?= BASE_URL ?>/index.php?url=game/store" method="post" enctype="multipart/form-data">
                <div>
                    <div>
                        <label for="title">Název hry <span>*</span></label>
                        <input type="text" id="title" name="title" required>
                    </div>
                    <div>
                        <label for="developer">Vývojář <span>*</span></label>
                        <input type="text" id="developer" name="developer" placeholder="např. CD Projekt Red" required>
                    </div>
                    <div>
                        <label for="publisher">Vydavatel</label>
                        <input type="text" id="publisher" name="publisher">
                    </div>
                    <div>
                        <label for="genre">Žánr <span>*</span></label>
                        <input type="text" id="genre" name="genre" placeholder="např. RPG, Akční" required>
                    </div>
                    <div>
                        <label for="platform">Platforma</label>
                        <input type="text" id="platform" name="platform" placeholder="PC, PS5, Xbox">
                    </div>
                    <div>
                        <label for="release_year">Rok vydání <span>*</span></label>
                        <input type="number" id="release_year" name="release_year" required>
                    </div>
                    <div>
                        <label for="price">Cena hry (Kč)</label>
                        <input type="number" id="price" name="price" step="0.5">
                    </div>
                    <div>
                        <label for="link">Odkaz (Steam/Epic)</label>
                        <input type="text" id="link" name="link">
                    </div>
                    <div>
                        <label for="description">Popis hry</label>
                        <textarea id="description" name="description" rows="5">Stručný popis hry: </textarea>
                    </div>    
                    <div>
                        <label>Obrázky (můžete nahrát více)</label>
                        <div style="border: 1px solid #ccc; padding: 10px; margin: 10px 0;">
                            <span>Vyberte soubory:</span><br>
                            <input type="file" id="images" name="images[]" multiple accept="image/*">
                        </div>
                    </div>
                    <div style="margin-top: 20px;">
                        <button type="submit" style="padding: 10px 20px; cursor: pointer;">Uložit hru do DB</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</body>
</html>