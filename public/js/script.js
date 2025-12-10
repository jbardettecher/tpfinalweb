async function addComment(postId, textareaEl) {
  const content = textareaEl.value.trim();
  if (!content) return alert('Message vide');
  const fd = new FormData();
  fd.append('post_id', postId);
  fd.append('content', content);

  const res = await fetch('/src/Controllers/AjaxController.php?a=addComment', {
    method: 'POST',
    body: fd
  });
  const json = await res.json();
  if (json.ok) {
    // minimal: append comment or reload
    location.reload();
  } else {
    alert(json.msg || 'Erreur');
  }
}

async function toggleLike(postId, btn) {
  const fd = new FormData();
  fd.append('post_id', postId);
  const res = await fetch('/src/Controllers/AjaxController.php?a=toggleLike', {
    method: 'POST',
    body: fd
  });
  const json = await res.json();
  if (json.ok) {
    btn.innerText = `❤ ${json.count}`;
  } else {
    alert(json.msg || 'Erreur');
  }
}
