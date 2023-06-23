package com.example.appdictionary

import retrofit2.Retrofit
import retrofit2.converter.gson.GsonConverterFactory

object FavoriteRepository {

    private const val BASE_URL = "http://192.168.2.21:8000/api"

    private val retrofit: Retrofit by lazy {
        Retrofit.Builder()
            .baseUrl(BASE_URL)
            .addConverterFactory(GsonConverterFactory.create())
            .build()
    }

    private val apiService: ApiInterface by lazy {
        retrofit.create(ApiInterface::class.java)
    }

    suspend fun getFavorites(id: Int): List<Favorite> {
        return apiService.getFavorites(1)
    }
}