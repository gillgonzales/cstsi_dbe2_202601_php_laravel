/* eslint-disable react/prop-types */
import { Link } from "react-router";
import { CardContainer, CardImage, CardMain } from "./card.styled";
import thumbImage from "../../assets/img/cards-thumbnail.jpg"
import VideoCard from "../VideoCard/VideoCard";

export const Cards = ({ item }) => {
    const srcMedia = item?.media?.length ? item?.media[0]?.source : thumbImage;
    // item.id==48 && console.log(item?.media)
    return (
        <CardContainer>
            <Link to={`/produto/${item.id}`}>
                <CardMain>
                    <h3>{item.nome}</h3>
                    <CardImage>
                        {item?.media[0]?.type === 'video'
                            ? <VideoCard url={srcMedia}/>
                            : <img src={srcMedia} />
                        }
                    </CardImage>
                    <h4>
                        R$ {item.preco}
                    </h4>
                    <p>
                        {item.descricao}
                    </p>
                </CardMain>
            </Link>
        </CardContainer>
    );
};
