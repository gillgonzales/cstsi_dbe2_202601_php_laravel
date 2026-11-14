export function extractYouTubeId(url) {
  if (!url) return null;

  try {
    const parsedUrl = new URL(url);

    // Padrão: https://www.youtube.com/watch?v=QAfTYrDhdHE
    if (parsedUrl.searchParams.has('v')) {
      return parsedUrl.searchParams.get('v');
    }

    // Padrão curto: https://youtu.be/QAfTYrDhdHE
    if (parsedUrl.hostname === 'youtu.be') {
      return parsedUrl.pathname.slice(1);
    }

    // Padrões embed ou shorts: /embed/ID ou /shorts/ID
    const pathMatch = parsedUrl.pathname.match(/\/(embed|shorts)\/([^/?]+)/);
    if (pathMatch) {
      return pathMatch[2];
    }
  } catch {
    // Fallback via Regex caso seja passada uma string parcial ou malformada
    const regexMatch = url.match(/(?:v=|\/)([0-9A-Za-z_-]{11})(?:[&?]|$)/);
    return regexMatch ? regexMatch[1] : null;
  }

  return null;
}
