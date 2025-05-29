document.querySelectorAll('p').forEach(p => {
    const words = p.textContent.trim().split(/\s+/);
    if (words.length > 150) {
        p.textContent = words.slice(0, 150).join(' ') + '...';
    }
});