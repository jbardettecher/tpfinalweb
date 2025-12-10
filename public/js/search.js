document.getElementById("live-search").addEventListener("keyup", async function() {
    let q = this.value.trim();
    if (q === "") {
        document.getElementById("results").innerHTML = "";
        return;
    }

    let res = await fetch(`/index.php?action=search_ajax&q=${encodeURIComponent(q)}`);
    let json = await res.json();

    let html = "";

    html += `<h5>Utilisateurs</h5>`;
    json.users.forEach(u => {
        html += `<p>👤 ${u.nom} (${u.email})</p>`;
    });

    html += `<h5>Publications</h5>`;
    json.posts.forEach(p => {
        html += `<p>📝 <a href="/index.php?action=post&id=${p.id}">${p.titre}</a></p>`;
    });

    html += `<h5>Commentaires</h5>`;
    json.comments.forEach(c => {
        html += `<p>💬 ${c.contenu}</p>`;
    });

    document.getElementById("results").innerHTML = html;
});
