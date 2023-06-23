package com.example.appdictionary

import androidx.appcompat.app.AppCompatActivity
import android.os.Bundle
import android.widget.TextView
import kotlinx.coroutines.GlobalScope
import kotlinx.coroutines.launch

class MainActivity : AppCompatActivity() {

    private lateinit var favoriteTextView: TextView
    private lateinit var favoriteList: List<Favorite>

    override fun onCreate(savedInstanceState: Bundle?) {
        super.onCreate(savedInstanceState)
        setContentView(R.layout.activity_main)

        favoriteTextView = findViewById(R.id.favoriteTextView)

        GlobalScope.launch {
            try {
                favoriteList = FavoriteRepository.getFavorites(1)
                val favoriteText = favoriteList.joinToString("\n") { it.word }
                favoriteTextView.text = favoriteText
            } catch (e: Exception) {
                // Handle the error
            }
        }
    }
}