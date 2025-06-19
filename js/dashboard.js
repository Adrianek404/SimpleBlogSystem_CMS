let activeScreenId = null;
document.querySelectorAll(".sidebar a").forEach(link => {
    link.addEventListener("click", e => {
        const screenId = link.dataset.screen;
        if (screenId) {
            e.preventDefault();
            if (activeScreenId === screenId) {
                document.querySelectorAll(".screen-section").forEach(section => {
                    section.classList.remove("active");
                });
                activeScreenId = null;
            } else {
                document.querySelectorAll(".screen-section").forEach(section => {
                    section.classList.remove("active");
                });

                const target = document.getElementById(screenId);
                if (target) {
                    target.classList.add("active");
                    activeScreenId = screenId;
                }
            }
        }
    });
});
let offset = 0;
const limit = 10;

function loadComments() {
    fetch(`../endpoints/load-comments.php?offset=${offset}&limit=${limit}`)
        .then(res => res.text())
        .then(html => {
            const list = document.getElementById('commentList');
            if (html.trim() === '') {
                document.getElementById('loadMoreBtn').disabled = true;
                document.getElementById('loadMoreBtn').textContent = 'Brak więcej komentarzy';
                return;
            }
            list.insertAdjacentHTML('beforeend', html);
            offset += limit;
        })
        .catch(err => console.error("Błąd ładowania komentarzy:", err));
}
loadPosts();
function loadPosts() {
    fetch(`../endpoints/load-posts.php`)
        .then(res => res.text())
        .then(html => {
            const list = document.getElementById('edit')
            if (html.trim() === '') {
                return;
            }
            list.insertAdjacentHTML('beforeend', html);
            postsActions();
        })
        .catch(err => console.error("Błąd ładowania postów:", err));
}

document.getElementById('loadMoreBtn').addEventListener('click', loadComments);


document.addEventListener('DOMContentLoaded', loadComments);

document.addEventListener('click', function (e) {
    if (e.target.matches('.delete-comment')) {
        const id = e.target.getAttribute('data-id');
        if (confirm("Czy na pewno chcesz usunąć komentarz?")) {
            fetch(`../endpoints/delete-comment.php`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `id=${encodeURIComponent(id)}`
            })
                .then(response => {
                    if (response.ok) {
                        response.text().then(() => {
                            e.target.closest('.comment-item').remove();
                        }).catch(error => {
                            console.error('Błąd:', error);
                        });
                    }
                })
        }
    }
});
function postsActions(){
    document.querySelectorAll('.post-item').forEach(item => {
        const toggleBtn = item.querySelector('.toggle-edit');
        const formContainer = item.querySelector('.post-edit-form');
        const form = formContainer.querySelector('form');
        const originalData = new FormData(form);

        let isModified = false;

        form.addEventListener('input', () => {
            const currentData = new FormData(form);
            isModified = false;
            for (let [key, value] of currentData.entries()) {
                if (originalData.get(key) !== value) {
                    isModified = true;
                    break;
                }
            }
        });

        toggleBtn.addEventListener('click', () => {
            if (formContainer.classList.contains('show')) {
                if (isModified) {
                    const confirmClose = confirm("Wprowadziłeś zmiany. Zapisać przed zamknięciem?");
                    if (!confirmClose) return;
                }
                formContainer.classList.remove('show');
            } else {
                document.querySelectorAll('.post-edit-form.show').forEach(openForm => {
                    openForm.classList.remove('show');
                });
                formContainer.classList.add('show');
                isModified = false;
            }
        });

        form.addEventListener('submit', (e) => {
            e.preventDefault();
            fetch('../endpoints/save-post.php', {
                method: 'POST',
                body: new FormData(form)
            })
                .then(res => res.text())
                .then(response => {
                    document.querySelectorAll('.post-edit-form.show').forEach(openForm => {
                        openForm.classList.remove('show');
                    });
                    alert("Zapisano zmiany");
                    isModified = false;
                }).catch(err => {
                    console.error(err);
                }
            )
        });
    });
}
