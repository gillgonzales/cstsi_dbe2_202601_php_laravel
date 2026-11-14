import YouTube from 'react-youtube';
import { extractYouTubeId } from '../../utils/parseVideoUrls';

const VideoCard = ({ url }) => {

    const videoId = extractYouTubeId(url);

    if (!videoId) return <p>URL de vídeo inválida.</p>;

    return <YouTube videoId={videoId} />
}

export default VideoCard

