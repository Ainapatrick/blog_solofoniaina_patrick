document.querySelectorAll('button[id^="emojiBtn-"]').forEach(button => {
  button.addEventListener('click', () => {
    const id = button.id.split('-')[1];
    const picker = document.getElementById(`emojiPicker-${id}`);

    if (picker.style.display === 'none' || picker.style.display === '') {
      picker.style.display = 'block';
    } else {
      picker.style.display = 'none';
    }
  });
});

//creation de nouveau emojis 
document.querySelectorAll('.emoji-btn').forEach(emojiBtn => {
  emojiBtn.addEventListener('click', (e) => {
    const emoji = e.currentTarget.getAttribute('data-emoji');
    const card = e.currentTarget.closest('.card');
    const articleId = card.querySelector('button[id^="emojiBtn-"]').id.split('-')[1];

    //AJAX (fetch)
    fetch(`index.php?controller=emoji&action=store`, {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
      },
      body: JSON.stringify({ article_id: articleId, code: emoji })
    })

      .then(res => res.json())
      .then(data => {
        console.log('Emoji enregistré:', data);
        //alert('tous est bien!');

        const countEmoji = document.getElementById(`emoji-count-${data.article_id}`);
        if (countEmoji) {
          countEmoji.textContent = `${data.emoji}`;
        }
        const emoji = document.getElementById(`emojiBtn-${data.article_id}`);
        if (emoji) {
          emoji.textContent = `${data.emoji}`; // ${data.count}`;
        }
        const userNom = document.getElementById(`user-code-${data.article_id}`);
        if (userNom) {
          userNom.textContent = `${data.nom_user} `;
        }

      })
      .catch(err => {
        console.error('Erreur:', err);
        alert('vous n\' envoyé pas l\'emoji.');
      });

    //fermer emoji picker après selection
    e.currentTarget.parentElement.style.display = 'none';
  });
});

// ajout de commentaire
document.querySelectorAll('.comment-form').forEach(form => {
  form.addEventListener('submit', function (e) {
    e.preventDefault();

    const formData = new FormData(this);
    const articleId = this.dataset.articleId;

    fetch(`index.php?controller=comment&action=store`, {
      method: 'POST',
      body: formData
    })
      .then(res => res.json())
      .then(data => {
        if (data.error) {
          alert(data.error);
          return;
        }
        console.log(data)
        const list = document.getElementById(`comments-list-${data.article_id}`);
        const newComment = `<p><strong>${data.user}</strong> (${data.created_at}): ${data.comment}</p>`;
        list.innerHTML = newComment;

        const countComent = document.getElementById(`comment-count-${data.article_id}`);
        if (countComent) {
          countComent.textContent = `💬 ${data.comment_count}`;
        }

        const comentCode = document.getElementById(`comment-code-${data.article_id}`);
        if (comentCode) {
          comentCode.textContent = `${data.comment_count} `;
        }

        const userNom = document.getElementById(`user-code-${data.article_id}`);
        if (userNom) {
          userNom.textContent = `${data.nom_user} `;
        }

        this.reset();
        const popup = document.getElementById(`btnSM-${articleId}`);
        if (popup) popup.style.display = 'none';
      })
      .catch(err => console.error(err));
  });

});

//fonction date 
function timeAgo(dateString) {
  const now = new Date();
  const past = new Date(dateString);
  const diff = Math.floor((now - past) / 1000); // différence en secondes

  if (diff < 60) return `il y a ${diff} sec`;
  if (diff < 3600) return `il y a ${Math.floor(diff / 60)} min`;
  if (diff < 86400) return `il y a ${Math.floor(diff / 3600)} h`;
  if (diff < 604800) return `il y a ${Math.floor(diff / 86400)} j`;
  if (diff < 2419200) return `il y a ${Math.floor(diff / 604800)} sem`;
  return past.toLocaleDateString('fr-FR'); // format normal si > 1 mois
}

// Bouton voir commentaires
document.querySelectorAll('.voir-comment').forEach(btn => {
  btn.addEventListener('click', function (e) {
    e.preventDefault();
    const articleId = this.dataset.articleId;
    console.log(articleId);
    const modalBody = document.getElementById(`modal-comments-body-${articleId}`);

    fetch(`index.php?controller=comment&action=listByArticle&id=${articleId}`)
      .then(res => res.json())
      .then(comments => {
        modalBody.innerHTML = comments.map(c =>
          `<p><strong>${c.nom}</strong>  ${timeAgo(c.created_at)}</p>
          <p>${c.contenu}</p> 
          <hr>`
        ).join('');

        new bootstrap.Modal(document.getElementById(`modalComments-${articleId}`)).show();
      })
      .catch(err => console.error(err));
  });
});

document.querySelectorAll('.like-btn').forEach(btn => {
  btn.addEventListener('click', function (e) {
    e.preventDefault();

    const articleId = this.dataset.articleId;
    const action = this.dataset.action;

    fetch(`index.php?controller=likes&action=${action}`, {
      method: 'POST',
      headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
      body: `article_id=${articleId}`
    })
      .then(res => res.json())
      .then(data => {
        if (data.error) {
          alert(data.error);
          return;
        }
        const likesEl = document.querySelector(`#likes-count-${data.article_id}`);
        if (likesEl) {
          likesEl.textContent = `👍 ${data.likes_count}`;
        }
        const likeCode = document.getElementById(`like-code-${data.article_id}`);
        const userNom = document.getElementById(`user-code-${data.article_id}`);

        if (data.liked) {
          likeCode.textContent = `👍`;
          userNom.textContent = `${data.user_nom} `;
          this.textContent = `❤️ ${data.likes_count}`
          this.dataset.action = 'delete';
          this.classList.remove('btn-outline-secondary');
          this.classList.add('btn-outline-success');
        } else {
          likeCode.textContent = ``;

          userNom.textContent = `${data.user_nom} `;
          this.textContent = `👍 ${data.likes_count}`
          this.dataset.action = 'store';
          this.classList.remove('btn-outline-success');
          this.classList.add('btn-outline-danger');
        }
      })
      .catch(err => console.error(err));
  });
});

document.querySelectorAll('button[id^="param"]').forEach(button => {
  button.addEventListener('click', () => {
    const id = button.id.split('-')[1];
    const popup = document.getElementById(`btnSM-${id}`);
    document.querySelectorAll('[id^="btnSM-"]').forEach(p => {
      if (p !== popup) p.style.display = 'none';
    });

    popup.style.display = (popup.style.display === 'none' || popup.style.display === '') ? 'block' : 'none';
  });
});

// fermer popup si on clique icon X
document.querySelectorAll('[data-close-popup]').forEach(closeBtn => {
  closeBtn.addEventListener('click', () => {
    const id = closeBtn.getAttribute('data-close-popup');
    document.getElementById(`btnSM-${id}`).style.display = 'none';
  });
});

// fermer le popup si on clique le page
document.addEventListener('click', (event) => {
  if (!event.target.closest('.position-relative')) {
    document.querySelectorAll('[id^="btnSM-"]').forEach(p => p.style.display = 'none');
  }
});

document.addEventListener('DOMContentLoaded', () => {
  const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
  tooltipTriggerList.forEach(function (tooltipTriggerEl) {
    new bootstrap.Tooltip(tooltipTriggerEl);
  });
});
