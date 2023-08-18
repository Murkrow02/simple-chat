function getInitials(name) {
    const words = name.trim().split(' ');
    let initials = '';

    for (let i = 0; i < words.length && initials.length < 2; i++) {
        initials += words[i][0].toUpperCase();
    }

    return initials;
}