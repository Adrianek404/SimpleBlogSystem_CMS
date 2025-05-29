document.querySelectorAll('p').forEach(p => {
    const words = p.textContent.trim().split(/\s+/);
    if (words.length > 200) {
        p.textContent = words.slice(0, 200).join(' ') + '...';
    }
});