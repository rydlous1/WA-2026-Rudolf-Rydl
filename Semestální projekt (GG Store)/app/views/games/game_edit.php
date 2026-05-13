<?php
/** @var array $game Toto říká editoru, že $game je pole a existuje */
/** @var array $comments A tohle platí pro komentáře */

require_once '../app/views/layout/header.php'; 
?>  

    <main class="container mx-auto px-6 py-10 flex-grow">
        
        <div class="max-w-3xl mx-auto">
            <div class="mb-6 flex items-center justify-between">
                <div>
                    <h2 class="text-3xl font-light tracking-widest text-slate-200 uppercase">
                        Upravit hru <span class="text-emerald-400 font-medium ml-2">#<?= htmlspecialchars($game['id']) ?></span>
                    </h2>
                    <p class="text-slate-200 italic mt-1 text-sm">Upravujete data pro hru: <strong class="text-slate-300"><?= htmlspecialchars($game['title']) ?></strong></p>
                </div>
                <a href="<?= BASE_URL ?>/index.php" class="text-slate-100 hover:text-white transition-colors text-sm uppercase tracking-wider">&larr; Zpět</a>
            </div>
            
            <div class="bg-slate-800/50 border border-slate-400 rounded-xl shadow-2xl backdrop-blur-sm p-6 md:p-8">
                <!-- ZMĚNA: url=game/update -->
                <form action="<?= BASE_URL ?>/index.php?url=game/update/<?= htmlspecialchars($game['id']) ?>" method="post" enctype="multipart/form-data">
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        
                        <div>
                            <label for="id_display" class="block text-xs font-semibold text-slate-500 mb-1 uppercase tracking-wider">ID v databázi</label>
                            <input type="text" id="id_display" value="<?= htmlspecialchars($game['id']) ?>" readonly 
                                   class="w-full bg-slate-900/80 border border-slate-700 rounded-md px-4 py-2 text-slate-500 cursor-not-allowed">
                        </div>

                        <div>
                            <label for="title" class="block text-xs font-semibold text-slate-100 mb-1 uppercase tracking-wider">Název hry <span class="text-rose-500">*</span></label>
                            <input type="text" id="title" name="title" value="<?= htmlspecialchars($game['title']) ?>" required 
                                   class="w-full bg-slate-900/50 border border-slate-400 rounded-md px-4 py-2 text-emerald-100 focus:outline-none focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 transition-colors">
                        </div>
                        
                        <div>
                            <label for="developer" class="block text-xs font-semibold text-slate-100 mb-1 uppercase tracking-wider">Vývojář <span class="text-rose-500">*</span></label>
                            <input type="text" id="developer" name="developer" value="<?= htmlspecialchars($game['developer']) ?>" required 
                                   class="w-full bg-slate-900/50 border border-slate-400 rounded-md px-4 py-2 text-slate-200 focus:outline-none focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 transition-colors">
                        </div>
                        
                        <div>
                            <label for="publisher" class="block text-xs font-semibold text-slate-100 mb-1 uppercase tracking-wider">Vydavatel</label>
                            <input type="text" id="publisher" name="publisher" value="<?= htmlspecialchars($game['publisher']) ?>" 
                                   class="w-full bg-slate-900/50 border border-slate-400 rounded-md px-4 py-2 text-slate-200 focus:outline-none focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 transition-colors">
                        </div>

                        <div>
                            <label for="release_year" class="block text-xs font-semibold text-slate-100 mb-1 uppercase tracking-wider">Rok vydání <span class="text-rose-500">*</span></label>
                            <input type="number" id="release_year" name="release_year" value="<?= htmlspecialchars($game['release_year']) ?>" required 
                                   class="w-full bg-slate-900/50 border border-slate-400 rounded-md px-4 py-2 text-slate-200 focus:outline-none focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 transition-colors">
                        </div>
                        
                        <!-- ZMĚNA: Select box změněn na textový input s předvyplněnou hodnotou -->
                        <div>
                            <label for="genre" class="block text-xs font-semibold text-slate-100 mb-1 uppercase tracking-wider">Žánr <span class="text-rose-500">*</span></label>
                            <input type="text" id="genre" name="genre" value="<?= htmlspecialchars($game['genre']) ?>" required 
                                   class="w-full bg-slate-900/50 border border-slate-400 rounded-md px-4 py-2 text-slate-200 focus:outline-none focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 transition-colors">
                        </div>
                        
                        <div>
                            <label for="platform" class="block text-xs font-semibold text-slate-100 mb-1 uppercase tracking-wider">Platforma</label>
                            <input type="text" id="platform" name="platform" value="<?= htmlspecialchars($game['platform']) ?>" 
                                   class="w-full bg-slate-900/50 border border-slate-400 rounded-md px-4 py-2 text-slate-200 focus:outline-none focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 transition-colors">
                        </div>
                        
                        <div>
                            <label for="price" class="block text-xs font-semibold text-slate-100 mb-1 uppercase tracking-wider">Cena hry (Kč)</label>
                            <input type="number" id="price" name="price" step="0.5" value="<?= htmlspecialchars($game['price']) ?>" 
                                   class="w-full bg-slate-900/50 border border-slate-400 rounded-md px-4 py-2 text-slate-200 focus:outline-none focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 transition-colors">
                        </div>
                        
                        <div>
                            <label for="link" class="block text-xs font-semibold text-slate-100 mb-1 uppercase tracking-wider">Odkaz</label>
                            <input type="text" id="link" name="link" value="<?= htmlspecialchars($game['link']) ?>" 
                                   class="w-full bg-slate-900/50 border border-slate-400 rounded-md px-4 py-2 text-slate-200 focus:outline-none focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 transition-colors">
                        </div>
                        
                        <div class="md:col-span-2">
                            <label for="description" class="block text-xs font-semibold text-slate-100 mb-1 uppercase tracking-wider">Popis hry</label>
                            <textarea id="description" name="description" rows="5" 
                                      class="w-full bg-slate-900/50 border border-slate-400 rounded-md px-4 py-2 text-slate-200 focus:outline-none focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 transition-colors"><?= htmlspecialchars($game['description']) ?></textarea>
                        </div>    
                        
                        <div class="md:col-span-2">
                            <label class="block text-xs font-semibold text-slate-100 mb-2 uppercase tracking-wider">Obrázky hry (přidat nové)</label>
                            <div class="w-full">
                                <label for="images" class="flex flex-col items-center justify-center w-full h-24 border-2 border-slate-400 border-dashed rounded-lg cursor-pointer bg-slate-800/30 hover:bg-slate-700/50 hover:border-emerald-400 transition-colors">
                                    <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                        <span id="file-title" class="text-sm text-slate-100 font-semibold">Klikni pro výběr souborů</span>
                                        <span id="file-info" class="text-xs text-slate-500 mt-1 text-center px-4">Žádné soubory nebyly vybrány</span>
                                    </div>
                                    <input type="file" id="images" name="images[]" multiple accept="image/*" class="hidden">
                                </label>
                            </div>
                        </div>
                        
                        <div class="md:col-span-2 mt-4">
                            <button type="submit" 
                                    class="w-full bg-gradient-to-r from-emerald-600 to-emerald-800 hover:from-emerald-500 hover:to-emerald-700 text-white font-bold py-3 px-4 rounded-md shadow-lg border border-emerald-500 transition-all uppercase tracking-widest text-sm">
                                Uložit změny do DB
                            </button>
                        </div>

                    </div>
                </form>
            </div>
        </div>
        <script>
            const fileInput = document.getElementById('images');
            const fileTitle = document.getElementById('file-title');
            const fileInfo = document.getElementById('file-info');

            fileInput.addEventListener('change', function(event) {
                const files = event.target.files;
                
                if (files.length === 0) {
                    fileTitle.textContent = 'Klikněte pro výběr souborů';
                    fileTitle.className = 'text-sm text-slate-100 font-semibold';
                    fileInfo.textContent = 'Žádné soubory nebyly vybrány';
                } else if (files.length === 1) {
                    fileTitle.textContent = 'Soubor připraven';
                    fileTitle.className = 'text-sm text-emerald-400 font-bold';
                    fileInfo.textContent = files[0].name;
                } else {
                    fileTitle.textContent = 'Soubory připraveny';
                    fileTitle.className = 'text-sm text-emerald-400 font-bold';
                    fileInfo.textContent = 'Vybráno celkem: ' + files.length + ' souborů';
                }
            });
        </script>
    </main>

<?php require_once '../app/views/layout/footer.php'; ?>