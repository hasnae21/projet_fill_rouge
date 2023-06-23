import React, { useState, useEffect} from 'react';
import axios from 'axios';
import trash from "./assets/trash-can-svgrepo-com.svg";

const Favorites = () => {
    const [favorites, setFavorites] = useState([]);
    useEffect(() => {
        const fetchData = async () => {
            console.log()
            const response = await axios.get('/api/favorites/1');
            setFavorites(response.data);
        };
        fetchData();
    }, []);

    const handleRemove = async (word) => {
        try {
            await axios.delete('/api/favorites/1', { params: { word } });
            const response = await axios.get('/api/favorites/1');
            setFavorites(response.data);
        } catch (error) {
            console.error(error);
        }
    };

    return (
        <div className="pt-10">
            <h1 className="text-custom-white text-2xl p-2 font-bold text-center" >Word saved</h1>
            {favorites.length > 0 ? (
                <ul className="text-custom-black text-xl p-8 font-semibold">
                    {favorites.map((favorite) => (
                        <li key={favorite.id} className="text-custom-black pt-2">
                            {favorite.word}{' '}
                            <button onClick={() => handleRemove(favorite.word)}>
                                <img
                                    src={trash}
                                    className="cursor-pointer p-2"
                                    width={44}
                                />
                            </button>
                        </li>
                    ))}
                </ul>
            ) : (
            <p className="text-custom-white text-2xl p-2 font-bold text-center">No favorites yet.</p>
            )}
        </div>
    );
};

export default Favorites;