document.querySelectorAll('button[id^="emojiBtn-"]').forEach(button => {
  button.addEventListener('click', () => {
    const id = button.id.split('-')[1];
    const picker = document.getElementById(`emojiPicker-${id}`);
    
    // Toggle visibility
    if (picker.style.display === 'none' || picker.style.display === '') {
      picker.style.display = 'block';
    } else {
      picker.style.display = 'none';
    }
  });
});

document.querySelectorAll('.emoji-btn').forEach(emojiBtn => {
  emojiBtn.addEventListener('click', (e) => {
    const emoji = e.currentTarget.getAttribute('data-emoji');
    const card = e.currentTarget.closest('.card');
    const articleId = card.querySelector('button[id^="emojiBtn-"]').id.split('-')[1];
console.log(emoji, card, articleId)

    // Fandefasana amin'ny AJAX (fetch)
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
      alert('tous est bien!');
    })
    .catch(err => {
      console.error('Erreur:', err);
      alert('vous n\' envoyé pas l\'emoji.');
    });

    // Fikatsoana ilay emoji picker aorian'ny selection
    e.currentTarget.parentElement.style.display = 'none';
  });
});


// Raha tianao dia azo ampio event hikatona ilay picker rehefa tsindrina ivelany
document.addEventListener('click', function(event) {
  document.querySelectorAll('.emoji-picker').forEach(picker => {
    if (!picker.contains(event.target) && !document.getElementById(picker.id.replace('emojiPicker-', 'emojiBtn-')).contains(event.target)) {
      picker.style.display = 'none';
    }
  });
});
