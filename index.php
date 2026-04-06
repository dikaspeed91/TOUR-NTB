<?php session_start(); ?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pesona NTB - Surga Tersembunyi di Indonesia</title>
    <meta name="description" content="Jelajahi keindahan tempat wisata dan kelezatan makanan khas Nusa Tenggara Barat (NTB).">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;800&display=swap" rel="stylesheet">
    
    <!-- CSS -->
    <link rel="stylesheet" href="style.css">
    
    <!-- Google Identity Services -->
    <script src="https://accounts.google.com/gsi/client" async></script>
</head>
<body>

    <!-- Navbar -->
    <nav id="navbar">
        <div class="logo">
            <span>PesonaNTB</span>
        </div>
        <div class="nav-links">
            <a href="#wisata">Destinasi</a>
            <a href="#kuliner">Kuliner</a>
            <a href="#peta">Peta Lokasi</a>
            
            <?php if(isset($_SESSION['user'])): ?>
                <div class="user-profile glass" style="padding: 0.5rem 1rem; border-radius: 50px;">
                    <img src="<?= htmlspecialchars($_SESSION['user']['picture']) ?>" alt="User Avatar">
                    <span><?= htmlspecialchars($_SESSION['user']['name']) ?></span>
                    <a href="logout.php" class="logout-btn">Keluar</a>
                </div>
            <?php else: ?>
                <button onclick="document.getElementById('loginModal').classList.add('active')" class="btn-maps" style="border: none; cursor: pointer;">
                    Login Akun
                </button>
            <?php endif; ?>
        </div>
    </nav>

    <!-- Login Modal -->
    <div class="login-overlay" id="loginModal">
        <button class="close-btn" onclick="document.getElementById('loginModal').classList.remove('active')">&times;</button>
        <div class="login-box glass">
            <h2>Selamat Datang!</h2>
            <p>Login menggunakan akun Google untuk menyimpan tempat favorit dan berinteraksi.</p>
            
            <div id="g_id_onload"
                 data-client_id="859187382218-0uph5iihdghj3375s85002t55smebopg.apps.googleusercontent.com"
                 data-callback="handleCredentialResponse"
                 data-auto_prompt="false">
            </div>
            <div class="g_id_signin" 
                 data-type="standard" 
                 data-size="large" 
                 data-theme="filled_black" 
                 data-text="sign_in_with" 
                 data-shape="pill" 
                 data-logo_alignment="left">
            </div>
        </div>
    </div>

    <!-- Comment Modal -->
    <div class="login-overlay" id="commentModal" style="align-items: flex-start; padding-top: 5rem;">
        <button class="close-btn" onclick="closeCommentModal()">&times;</button>
        <div class="login-box glass" style="max-width: 600px; max-height: 80vh; overflow-y: auto; text-align: left; padding: 2rem;">
            <h2 id="commentTitle" style="text-align: center; margin-bottom: 2rem;">Ulasan</h2>
            
            <div id="commentList" style="margin-bottom: 2rem;">
                <!-- Comments injected here -->
            </div>

            <?php if(isset($_SESSION['user'])): ?>
                <div class="comment-form" style="border-top: 1px solid rgba(255,255,255,0.1); padding-top: 1.5rem;">
                    <h3 style="margin-bottom: 1rem;">Berikan Ulasan Anda</h3>
                    <div class="rating-stars" style="margin-bottom: 1rem; color: var(--accent); font-size: 1.8rem; cursor: pointer;">
                        <span onclick="setRating(1)">★</span><span onclick="setRating(2)">★</span><span onclick="setRating(3)">★</span><span onclick="setRating(4)">★</span><span onclick="setRating(5)">★</span>
                    </div>
                    <input type="hidden" id="ratingValue" value="5">
                    <textarea id="commentText" rows="4" style="width: 100%; padding: 1rem; border-radius: 8px; background: rgba(0,0,0,0.3); color: white; border: 1px solid rgba(255,255,255,0.2); margin-bottom: 1rem; font-family: inherit;" placeholder="Bagaimana pengalaman Anda tentang tempat ini?"></textarea>
                    <button onclick="submitComment()" class="btn-maps" style="width: 100%; justify-content: center; border: none; cursor: pointer; font-size: 1.1rem; padding: 1rem;">Kirim Ulasan</button>
                    <input type="hidden" id="currentCommentItemId" value="">
                </div>
            <?php else: ?>
                <div style="text-align: center; padding: 2rem; background: rgba(255,255,255,0.05); border-radius: 12px; margin-top: 2rem;">
                    <p style="margin-bottom: 1rem;">Anda harus login untuk membaca sepenuhnya dan memberikan ulasan.</p>
                    <button onclick="closeCommentModal(); document.getElementById('loginModal').classList.add('active')" class="btn-maps" style="border: none; cursor: pointer;">Login Sekarang</button>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Hero Section -->
    <header class="hero">
        <h1>Jelajahi Surga di <br><span>Nusa Tenggara Barat</span></h1>
        <p>Temukan destinasi wisata mendunia dan nikmati kelezatan kuliner khas yang tak terlupakan dari Pulau Lombok hingga Sumbawa.</p>
        <a href="#wisata" class="btn-maps">Mulai Petualangan</a>
    </header>

    <!-- Wisata Section -->
    <section id="wisata">
        <h2 class="section-title">Destinasi <span>Wisata</span> Terpopuler</h2>
        <div class="grid">
            <!-- Card 1 -->
            <div class="card glass" data-id="rinjani">
                <img src="images/RINJANI.jfif" alt="Gunung Rinjani" class="card-img">
                <h3>Gunung Rinjani</h3>
                <p>Gunung berapi tertinggi kedua di Indonesia, menawarkan pemandangan spektakuler Danau Segara Anak di kalderanya.</p>
                <div style="display: flex; gap: 0.5rem; flex-wrap: wrap;">
                    <a href="https://maps.app.goo.gl/kXzB8jPcwN8N8yXb6" target="_blank" class="btn-maps" style="flex: 1; justify-content: center; font-size: 0.9rem;">
                        <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg> Peta
                    </a>
                    <button onclick="openCommentModal('rinjani', 'Gunung Rinjani')" class="btn-maps" style="flex: 1; justify-content: center; background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.2); font-size: 0.9rem; cursor: pointer;">
                        ⭐ Ulasan
                    </button>
                </div>
            </div>
            
            <!-- Card 2 -->
            <div class="card glass" data-id="gili_trawangan">
                <img src="images/GILI%20TRAWANGAN.jfif" alt="Gili Trawangan" class="card-img">
                <h3>Gili Trawangan</h3>
                <p>Pulau kecil dengan pasir putih bersih, air laut sebening kristal, bebas kendaraan bermotor, dan pesta pesisir yang meriah.</p>
                <div style="display: flex; gap: 0.5rem; flex-wrap: wrap;">
                    <a href="https://maps.app.goo.gl/hGz7NQXo8n3uY9kQ9" target="_blank" class="btn-maps" style="flex: 1; justify-content: center; font-size: 0.9rem;">
                        <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg> Peta
                    </a>
                    <button onclick="openCommentModal('gili_trawangan', 'Gili Trawangan')" class="btn-maps" style="flex: 1; justify-content: center; background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.2); font-size: 0.9rem; cursor: pointer;">
                        ⭐ Ulasan
                    </button>
                </div>
            </div>

            <!-- Card 3 -->
            <div class="card glass" data-id="pantai_pink">
                <img src="images/PANTAI%20PINK.jfif" alt="Pantai Pink" class="card-img">
                <h3>Pantai Pink (Tangsi)</h3>
                <p>Keajaiban alam berupa pantai dengan pasir berwarna merah muda muda akibat karang merah muda yang terkikis ombak.</p>
                <div style="display: flex; gap: 0.5rem; flex-wrap: wrap;">
                    <a href="https://maps.app.goo.gl/3XZb6JbL9z8y9QZ27" target="_blank" class="btn-maps" style="flex: 1; justify-content: center; font-size: 0.9rem;">
                        <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg> Peta
                    </a>
                    <button onclick="openCommentModal('pantai_pink', 'Pantai Pink (Tangsi)')" class="btn-maps" style="flex: 1; justify-content: center; background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.2); font-size: 0.9rem; cursor: pointer;">
                        ⭐ Ulasan
                    </button>
                </div>
            </div>

            <!-- Card 4: Pulau Moyo -->
            <div class="card glass" data-id="pulau_moyo">
                <img src="images/PULAU%20MOYO.jfif" alt="Pulau Moyo" class="card-img">
                <h3>Pulau Moyo (Sumbawa)</h3>
                <p>Surga tersembunyi di Sumbawa dengan Air Terjun Mata Jitu yang memukau, keindahannya pernah dikunjungi oleh mendiang Lady Diana.</p>
                <div style="display: flex; gap: 0.5rem; flex-wrap: wrap;">
                    <a href="https://maps.app.goo.gl/yM26Z9QZz1J2HqJ29" target="_blank" class="btn-maps" style="flex: 1; justify-content: center; font-size: 0.9rem;">
                        <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg> Peta
                    </a>
                    <button onclick="openCommentModal('pulau_moyo', 'Pulau Moyo')" class="btn-maps" style="flex: 1; justify-content: center; background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.2); font-size: 0.9rem; cursor: pointer;">
                        ⭐ Ulasan
                    </button>
                </div>
            </div>

            <!-- Card 5: Gunung Tambora -->
            <div class="card glass" data-id="tambora">
                <img src="images/TAMBORA.jfif" alt="Gunung Tambora" class="card-img">
                <h3>Gunung Tambora (Sumbawa)</h3>
                <p>Gunung bersejarah dengan kaldera raksasa di Pulau Sumbawa, menawarkan jalur pendakian eksotis padang savana menakjubkan.</p>
                <div style="display: flex; gap: 0.5rem; flex-wrap: wrap;">
                    <a href="https://maps.app.goo.gl/B2M7uD2yvL4L2Vz28" target="_blank" class="btn-maps" style="flex: 1; justify-content: center; font-size: 0.9rem;">
                        <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg> Peta
                    </a>
                    <button onclick="openCommentModal('tambora', 'Gunung Tambora')" class="btn-maps" style="flex: 1; justify-content: center; background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.2); font-size: 0.9rem; cursor: pointer;">
                        ⭐ Ulasan
                    </button>
                </div>
            </div>

            <!-- Card 6: Pantai Lakey -->
            <div class="card glass" data-id="pantai_lakey">
                <img src="images/PANTAI%20LAKEY.jpeg" alt="Pantai Lakey" class="card-img">
                <h3>Pantai Lakey (Dompu)</h3>
                <p>Pantai eksotis dengan ombak kidal (left-hander) unik yang menjadi surga bagi peselancar profesional dari berbagai belahan dunia.</p>
                <div style="display: flex; gap: 0.5rem; flex-wrap: wrap;">
                    <a href="https://maps.app.goo.gl/5M76x1s8tXo4U9U66" target="_blank" class="btn-maps" style="flex: 1; justify-content: center; font-size: 0.9rem;">
                        <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg> Peta
                    </a>
                    <button onclick="openCommentModal('pantai_lakey', 'Pantai Lakey')" class="btn-maps" style="flex: 1; justify-content: center; background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.2); font-size: 0.9rem; cursor: pointer;">
                        ⭐ Ulasan
                    </button>
                </div>
            </div>

            <!-- Card 7: Pantai Lariti -->
            <div class="card glass" data-id="pantai_lariti">
                <img src="images/PANTAI%20LARITI.jfif" alt="Pantai Lariti" class="card-img">
                <h3>Pantai Lariti (Bima)</h3>
                <p>Pantai menakjubkan dengan fenomena laut terbelah (sandbar) yang memungkinkan Anda berjalan kaki ke pulau karang saat air laut surut.</p>
                <div style="display: flex; gap: 0.5rem; flex-wrap: wrap;">
                    <a href="https://maps.app.goo.gl/x8H2XZAzyP8E1Z1E6" target="_blank" class="btn-maps" style="flex: 1; justify-content: center; font-size: 0.9rem;">
                        <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg> Peta
                    </a>
                    <button onclick="openCommentModal('pantai_lariti', 'Pantai Lariti')" class="btn-maps" style="flex: 1; justify-content: center; background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.2); font-size: 0.9rem; cursor: pointer;">
                        ⭐ Ulasan
                    </button>
                </div>
            </div>
        </div>
    </section>

    <!-- Kuliner Section -->
    <section id="kuliner" style="background: rgba(14, 165, 233, 0.03);">
        <h2 class="section-title">Kenikmatan <span>Kuliner</span> Khas</h2>
        <div class="grid">
            <div class="card glass" data-id="ayam_taliwang">
                <img src="images/AYAM%20TALIWANG.jfif" alt="Ayam Taliwang" class="card-img">
                <h3>Ayam Taliwang</h3>
                <p>Ayam bakar pedas manis khas Lombok yang dibakar dengan bumbu terasi, cabai, dan rempah lainnya. Sangat nikmat disajikan dengan plecing kangkung.</p>
                <div style="display: flex; gap: 0.5rem; flex-wrap: wrap;">
                    <a href="https://maps.app.goo.gl/t63z7K3bJ2b3p3X59" target="_blank" class="btn-maps" style="flex: 1; justify-content: center; font-size: 0.9rem;">Restoran Terdekat</a>
                    <button onclick="openCommentModal('ayam_taliwang', 'Ayam Taliwang')" class="btn-maps" style="flex: 1; justify-content: center; background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.2); font-size: 0.9rem; cursor: pointer;">⭐ Ulasan</button>
                </div>
            </div>

            <div class="card glass" data-id="plecing_kangkung">
                <img src="images/PLECING%20KANGKUNG.jfif" alt="Plecing Kangkung" class="card-img">
                <h3>Plecing Kangkung</h3>
                <p>Kangkung rebus khas Lombok yang disajikan dalam keadaan dingin dengan sambal tomat pedas, perasan jeruk limau, dan kelapa parut.</p>
                 <div style="display: flex; gap: 0.5rem; flex-wrap: wrap;">
                    <a href="https://maps.app.goo.gl/t63z7K3bJ2b3p3X59" target="_blank" class="btn-maps" style="flex: 1; justify-content: center; font-size: 0.9rem;">Restoran Terdekat</a>
                    <button onclick="openCommentModal('plecing_kangkung', 'Plecing Kangkung')" class="btn-maps" style="flex: 1; justify-content: center; background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.2); font-size: 0.9rem; cursor: pointer;">⭐ Ulasan</button>
                </div>
            </div>

            <div class="card glass" data-id="sate_bulayak">
                <img src="images/SATE%20BULAYAK.jfif" alt="Sate Bulayak" class="card-img">
                <h3>Sate Bulayak</h3>
                <p>Sate daging sapi yang disantap bersama bulayak (lontong ketan yang dililit dengan daun enau), disajikan dengan bumbu kacang gurih.</p>
                <div style="display: flex; gap: 0.5rem; flex-wrap: wrap;">
                    <a href="https://maps.app.goo.gl/t63z7K3bJ2b3p3X59" target="_blank" class="btn-maps" style="flex: 1; justify-content: center; font-size: 0.9rem;">Restoran Terdekat</a>
                    <button onclick="openCommentModal('sate_bulayak', 'Sate Bulayak')" class="btn-maps" style="flex: 1; justify-content: center; background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.2); font-size: 0.9rem; cursor: pointer;">⭐ Ulasan</button>
                </div>
            </div>

            <!-- Card 4: Singang -->
            <div class="card glass" data-id="singang">
                <img src="images/SINGANG.jfif" alt="Singang" class="card-img">
                <h3>Singang (Sumbawa)</h3>
                <p>Gulai ikan khas Sumbawa dengan kuah kuning rempah yang dimasak dengan belimbing wuluh dan asam, sangat gurih dan nikmat menyegarkan.</p>
                 <div style="display: flex; gap: 0.5rem; flex-wrap: wrap;">
                    <a href="https://maps.app.goo.gl/t63z7K3bJ2b3p3X59" target="_blank" class="btn-maps" style="flex: 1; justify-content: center; font-size: 0.9rem;">Restoran Terdekat</a>
                    <button onclick="openCommentModal('singang', 'Singang')" class="btn-maps" style="flex: 1; justify-content: center; background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.2); font-size: 0.9rem; cursor: pointer;">⭐ Ulasan</button>
                </div>
            </div>

            <!-- Card 5: Sepat -->
            <div class="card glass" data-id="sepat">
                <img src="images/SEPAT.jfif" alt="Sepat" class="card-img">
                <h3>Sepat (Sumbawa)</h3>
                <p>Sajian ikan bakar yang disiram dengan kuah asam segar, rempah-rempah basah, dan tomat, memberikan sensasi tradisional yang menggugah selera.</p>
                <div style="display: flex; gap: 0.5rem; flex-wrap: wrap;">
                    <a href="https://maps.app.goo.gl/t63z7K3bJ2b3p3X59" target="_blank" class="btn-maps" style="flex: 1; justify-content: center; font-size: 0.9rem;">Restoran Terdekat</a>
                    <button onclick="openCommentModal('sepat', 'Sepat')" class="btn-maps" style="flex: 1; justify-content: center; background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.2); font-size: 0.9rem; cursor: pointer;">⭐ Ulasan</button>
                </div>
            </div>

            <!-- Card 6: Timbu -->
            <div class="card glass" data-id="timbu">
                <img src="images/TIMBU.jfif" alt="Timbu" class="card-img">
                <h3>Timbu / Lemang (Dompu)</h3>
                <p>Hidangan beras ketan lezat yang dibakar di dalam selongsong bambu muda berlapis daun pisang. Sering disajikan dalam acara adat istimewa.</p>
                <div style="display: flex; gap: 0.5rem; flex-wrap: wrap;">
                    <a href="https://maps.app.goo.gl/hGz7NQXo8n3uY9kQ9" target="_blank" class="btn-maps" style="flex: 1; justify-content: center; font-size: 0.9rem;">Restoran Terdekat</a>
                    <button onclick="openCommentModal('timbu', 'Timbu (Lemang)')" class="btn-maps" style="flex: 1; justify-content: center; background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.2); font-size: 0.9rem; cursor: pointer;">⭐ Ulasan</button>
                </div>
            </div>

            <!-- Card 7: Uta Palumara -->
            <div class="card glass" data-id="uta_palumara">
                <img src="images/UTA%20PALUMARA.jfif" alt="Uta Palumara" class="card-img">
                <h3>Uta Palumara (Bima)</h3>
                <p>Sajian ikan bandeng segar dengan bumbu kuah kuning asam pedas yang dicampur kemangi, memberikan sensasi rasa unik dan sangat menyegarkan.</p>
                <div style="display: flex; gap: 0.5rem; flex-wrap: wrap;">
                    <a href="https://maps.app.goo.gl/hGz7NQXo8n3uY9kQ9" target="_blank" class="btn-maps" style="flex: 1; justify-content: center; font-size: 0.9rem;">Restoran Terdekat</a>
                    <button onclick="openCommentModal('uta_palumara', 'Uta Palumara')" class="btn-maps" style="flex: 1; justify-content: center; background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.2); font-size: 0.9rem; cursor: pointer;">⭐ Ulasan</button>
                </div>
            </div>
        </div>
    </section>

    <!-- Peta Section -->
    <section id="peta">
        <h2 class="section-title">Peta <span>Nusa Tenggara Barat</span></h2>
        <div class="map-container glass" style="padding: 10px;">
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2024765.73356024!2d116.1437!3d-8.6528!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2dcdec4902bd5de1%3A0xeabf521ae33bb271!2sWest%20Nusa%20Tenggara!5e0!3m2!1sen!2sid!4v1700000000000!5m2!1sen!2sid" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>
    </section>

    <footer>
        <p>&copy; 2026 Pesona NTB | Wisata & Kuliner Nusa Tenggara Barat.</p>
    </footer>

    <script>
        // Navbar scroll effect
        window.addEventListener('scroll', () => {
            const nav = document.getElementById('navbar');
            if (window.scrollY > 50) {
                nav.classList.add('scrolled');
            } else {
                nav.classList.remove('scrolled');
            }
        });

        // Google Login Handler
        function handleCredentialResponse(response) {
            fetch('login_process.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ credential: response.credential })
            })
            .then(res => res.json())
            .then(data => {
                if (data.status === 'success') {
                    window.location.reload(); 
                } else {
                    alert('Gagal login: ' + data.message);
                }
            })
            .catch(err => {
                console.error(err);
                alert('Terjadi kesalahan saat memproses login.');
            });
        }

        // Comment System Logic
        let currentRating = 5;
        function setRating(val) {
            currentRating = val;
            document.getElementById('ratingValue').value = val;
            const stars = document.querySelectorAll('.rating-stars span');
            stars.forEach((star, index) => {
                star.style.opacity = index < val ? '1' : '0.3';
            });
        }

        function openCommentModal(itemId, title) {
            document.getElementById('commentModal').classList.add('active');
            document.getElementById('commentTitle').innerText = 'Ulasan: ' + title;
            const idField = document.getElementById('currentCommentItemId');
            if(idField) idField.value = itemId;

            const list = document.getElementById('commentList');
            list.innerHTML = '<p style="text-align:center;">Memuat ulasan...</p>';
            
            fetch('get_comments.php?item_id=' + itemId)
            .then(res => res.json())
            .then(data => {
                if (data.length === 0) {
                    list.innerHTML = '<p style="text-align:center; color: var(--text-muted);">Belum ada ulasan. Jadilah yang pertama!</p>';
                } else {
                    list.innerHTML = data.map(c => `
                        <div style="background: rgba(255,255,255,0.05); padding: 1rem; border-radius: 8px; margin-bottom: 1rem; border: 1px solid rgba(255,255,255,0.05);">
                            <div style="display: flex; align-items: center; gap: 1rem; margin-bottom: 0.5rem;">
                                <img src="${c.picture}" style="width: 32px; height: 32px; border-radius: 50%; border: 1px solid var(--primary);" onerror="this.src='https://ui-avatars.com/api/?name=User&background=0D8ABC&color=fff'">
                                <strong>${c.user}</strong>
                                <span style="color: var(--accent); font-size: 0.9rem;">${'★'.repeat(c.rating)}${'☆'.repeat(5-c.rating)}</span>
                                <small style="color: var(--text-muted); margin-left: auto;">${c.date}</small>
                            </div>
                            <p style="margin:0; font-size: 0.95rem; color: var(--text-light); opacity: 0.9;">${c.text}</p>
                        </div>
                    `).join('');
                }
            })
            .catch(err => {
                list.innerHTML = '<p style="text-align:center; color: red;">Gagal memuat ulasan.</p>';
            });
        }

        function closeCommentModal() {
            document.getElementById('commentModal').classList.remove('active');
        }

        function submitComment() {
            const itemId = document.getElementById('currentCommentItemId').value;
            const text = document.getElementById('commentText').value;
            const rating = document.getElementById('ratingValue').value;

            if(!text.trim()) { alert('Tuliskan ulasan Anda!'); return; }

            const btn = event.target;
            btn.innerText = 'Mengirim...';
            btn.disabled = true;

            fetch('submit_comment.php', {
                method: 'POST',
                headers: {'Content-Type': 'application/json'},
                body: JSON.stringify({ item_id: itemId, text: text, rating: rating })
            })
            .then(res => res.json())
            .then(data => {
                btn.innerText = 'Kirim Ulasan';
                btn.disabled = false;
                if(data.status === 'success') {
                    document.getElementById('commentText').value = '';
                    setRating(5); // reset stars
                    openCommentModal(itemId, document.getElementById('commentTitle').innerText.replace('Ulasan: ', ''));
                } else {
                    alert(data.message);
                }
            })
            .catch(err => {
                btn.innerText = 'Kirim Ulasan';
                btn.disabled = false;
                alert('Terjadi kesalahan koneksi.');
            });
        }
    </script>
</body>
</html>
