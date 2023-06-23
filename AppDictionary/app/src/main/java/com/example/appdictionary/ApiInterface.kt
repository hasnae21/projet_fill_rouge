package com.example.appdictionary

import retrofit2.http.GET
import retrofit2.http.Path

interface ApiInterface {
    @GET("/favorites/{id}")
    suspend fun getFavorites(@Path("id") id: Int): List<Favorite>
}