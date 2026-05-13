<?php
/** @var array $game */
?>
<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GGstore - Upravit hru (Prostá verze)</title>
</head>
<body>
    <div>
        <p>
            <a href="<?= BASE_URL ?>/index.php">&larr; Zpět na seznam her</a>
        </p>

        <div>
            <h2>Upravit hru (ID záznamu: <?= htmlspecialchars($game['id']) ?>)</h2>
            <p>Upravujete data pro hru: <strong><?= htmlspecialchars($game['title']) ?></strong></p>
            <p>Změňte požadované údaje a uložte formulář.</p>
        </div>
        
        <div>
            <form action="<?= BASE_URL ?>/index.php?url=game/update/<?= htmlspecialchars($game['id']) ?>" method="post" enctype="multipart/form-data">
                <div>
                    <div>
                        <label for="id_display">ID v databázi</label>
                        <input type="text" id="id_display" value="<?= htmlspecialchars($game['id']) ?>" readonly>
                    </div>
                    <div>
                        <label for="title">Název hry <span>*</span></label>
                        <input type="text" id="title" name="title" value="<?= htmlspecialchars($game['title']) ?>" required>
                    </div>
                    <div>
                        <label for="developer">Vývojář <span>*</span></label>
                        <input type="text" id="developer" name="developer" value="<?= htmlspecialchars($game['developer']) ?>" required>
                    </div>
                    <div>
                        <label for="publisher">Vydavatel</label>
                        <input type="text" id="publisher" name="publisher" value="<?= htmlspecialchars($game['publisher']) ?>">
                    </div>
                    <div>
                        <label for="genre">Žánr <span>*</span></label>
                        <input type="text" id="genre" name="genre" value="<?= htmlspecialchars($game['genre']) ?>" required>
                    </div>
                    <div>
                        <label for="platform">Platforma</label>
                        <input type="text" id="platform" name="platform" value="<?= htmlspecialchars($game['platform']) ?>">
                    </div>
                    <div>
                        <label for="release_year">Rok vydání <span>*</span></label>
                        <input type="number" id="release_year" name="release_year" value="<?= htmlspecialchars($game['release_year']) ?>" required>
                    </div>
                    <div>
                        <label for="price">Cena hry (Kč)</label>
                        <input type="number" id="price" name="price" step="0.5" value="<?= htmlspecialchars($game['price']) ?>">
                    </div>
                    <div>
                        <label for="link">Odkaz (Steam/Epic)</label>
                        <input type="text" id="link" name="link" value="<?= htmlspecialchars($game['link']) ?>">
                    </div>
                    <div>
                        <label for="description">Popis hry</label>
                        <textarea id="description" name="description" rows="5"><?= htmlspecialchars($game['description']) ?></textarea>
                    </div>    
                    <div>
                        <label>Obrázky (přidat nové)</label>
                        <label>
                            <input type="file" id="images" name="images[]" multiple accept="image/*">
                        </label>
                    </div>
                    <div style="margin-top: 20px;">
                        <button type="submit">Uložit změny do DB</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</body>
</html>