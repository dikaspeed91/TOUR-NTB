// Update Authentication UI globally based on LocalStorage
function updateAuthUI() {
    const authContainer = document.getElementById('authContainer');
    const userStr = localStorage.getItem('user');
    
    if (userStr) {
        const user = JSON.parse(userStr);
        authContainer.innerHTML = `
            <div class="user-profile glass" style="padding: 0.5rem 1rem; border-radius: 50px; background: rgba(255,255,255,0.05); gap: 0.8rem; display: flex; align-items: center;">
                <img src="${user.picture}" alt="User Avatar" style="width: 35px; height: 35px; border-radius: 50%;" onerror="this.src='https://ui-avatars.com/api/?name=${user.name}&background=0ea5e9&color=fff'">
                <span style="font-size: 0.95rem;">${user.name}</span>
                <a href="#" onclick="logout(event)" class="logout-btn" style="margin-left: 0.5rem; text-decoration: none;">Keluar</a>
            </div>
        `;
    } else {
        authContainer.innerHTML = `
            <button onclick="document.getElementById('loginModal').classList.add('active')" class="btn-maps" style="border: none; cursor: pointer; padding: 0.5rem 1.2rem;">
                Login Akun
            </button>
        `;
    }
}

// Init UI
updateAuthUI();

// Navbar scroll effect
window.addEventListener('scroll', () => {
    const nav = document.getElementById('navbar');
    if (window.scrollY > 50) {
        nav.classList.add('scrolled');
    } else {
        nav.classList.remove('scrolled');
    }
});

// Google JWT Decoder
function decodeJwtResponse(token) {
    const base64Url = token.split('.')[1];
    const base64 = base64Url.replace(/-/g, '+').replace(/_/g, '/');
    const jsonPayload = decodeURIComponent(window.atob(base64).split('').map(function(c) {
        return '%' + ('00' + c.charCodeAt(0).toString(16)).slice(-2);
    }).join(''));
    return JSON.parse(jsonPayload);
}

// Google Login Callback
function handleCredentialResponse(response) {
    try {
        const payload = decodeJwtResponse(response.credential);
        const user = {
            name: payload.name,
            email: payload.email,
            picture: payload.picture
        };
        localStorage.setItem('user', JSON.stringify(user));
        document.getElementById('loginModal').classList.remove('active');
        updateAuthUI();
        alert('Berhasil Login! Anda sekarang dapat memberikan ulasan secara lokal.');
    } catch (err) {
        console.error(err);
        alert('Terdapat kesalahan saat membaca token login. Pastikan URL terbuka normal.');
    }
}

function logout(e) {
    e.preventDefault();
    localStorage.removeItem('user');
    updateAuthUI();
    
    // Re-render open modal if present
    const modal = document.getElementById('commentModal');
    if (modal.classList.contains('active')) {
        const id = document.getElementById('currentCommentItemId').value;
        const title = document.getElementById('commentTitle').innerText.replace('Ulasan: ', '');
        openCommentModal(id, title);
    }
}

// Comment System Logic (100% LocalStorage)
let currentRating = 5;
function setRating(val) {
    currentRating = val;
    document.getElementById('ratingValue').value = val;
    const stars = document.querySelectorAll('.rating-stars span');
    stars.forEach((star, index) => {
        star.style.opacity = index < val ? '1' : '0.3';
    });
}

function getLocalComments(itemId) {
    const dataStr = localStorage.getItem('comments_data');
    const data = dataStr ? JSON.parse(dataStr) : {};
    return data[itemId] || [];
}

function saveLocalComment(itemId, newComment) {
    const dataStr = localStorage.getItem('comments_data');
    const data = dataStr ? JSON.parse(dataStr) : {};
    if (!data[itemId]) data[itemId] = [];
    data[itemId].unshift(newComment); // Add to top
    localStorage.setItem('comments_data', JSON.stringify(data));
}

function renderCommentsList(comments) {
    const list = document.getElementById('commentList');
    if (comments.length === 0) {
        list.innerHTML = '<p style="text-align:center; color: var(--text-muted);">Belum ada ulasan. Jadilah yang pertama!</p>';
    } else {
        list.innerHTML = comments.map(c => `
            <div style="background: rgba(255,255,255,0.05); padding: 1rem; border-radius: 8px; margin-bottom: 1rem; border: 1px solid rgba(255,255,255,0.05);">
                <div style="display: flex; align-items: center; gap: 1rem; margin-bottom: 0.5rem;">
                    <img src="${c.picture}" style="width: 32px; height: 32px; border-radius: 50%; border: 1px solid var(--primary);" onerror="this.src='https://ui-avatars.com/api/?name=${c.user}&background=0D8ABC&color=fff'">
                    <strong>${c.user}</strong>
                    <span style="color: var(--accent); font-size: 0.9rem;">${'★'.repeat(c.rating)}${'☆'.repeat(5-c.rating)}</span>
                    <small style="color: var(--text-muted); margin-left: auto;">${c.date}</small>
                </div>
                <p style="margin:0; font-size: 0.95rem; color: var(--text-light); opacity: 0.9;">${c.text}</p>
            </div>
        `).join('');
    }
}

function openCommentModal(itemId, title) {
    document.getElementById('commentModal').classList.add('active');
    document.getElementById('commentTitle').innerText = 'Ulasan: ' + title;
    
    const idField = document.getElementById('currentCommentItemId');
    if(idField) idField.value = itemId;

    // Load & Render Comments Array
    const comments = getLocalComments(itemId);
    renderCommentsList(comments);

    // Toggle visibility logic based on login
    const isLogged = !!localStorage.getItem('user');
    if (isLogged) {
        document.getElementById('commentFormContainer').style.display = 'block';
        document.getElementById('commentLoginPrompt').style.display = 'none';
    } else {
        document.getElementById('commentFormContainer').style.display = 'none';
        document.getElementById('commentLoginPrompt').style.display = 'block';
    }
}

function closeCommentModal() {
    document.getElementById('commentModal').classList.remove('active');
}

function submitComment() {
    const userStr = localStorage.getItem('user');
    if (!userStr) return alert("Silakan login dulu.");
    
    const user = JSON.parse(userStr);
    const itemId = document.getElementById('currentCommentItemId').value;
    const text = document.getElementById('commentText').value.trim();
    const rating = parseInt(document.getElementById('ratingValue').value);

    if(!text) { alert('Harap isi kolom komentar!'); return; }

    const now = new Date();
    const newComment = {
        user: user.name,
        picture: user.picture,
        rating: rating,
        text: text,
        date: now.getFullYear() + '-' + String(now.getMonth()+1).padStart(2,'0') + '-' + String(now.getDate()).padStart(2,'0') + ' ' + String(now.getHours()).padStart(2,'0') + ':' + String(now.getMinutes()).padStart(2,'0')
    };

    saveLocalComment(itemId, newComment);

    // Reset & Reload Form
    document.getElementById('commentText').value = '';
    setRating(5);
    openCommentModal(itemId, document.getElementById('commentTitle').innerText.replace('Ulasan: ', ''));
}
