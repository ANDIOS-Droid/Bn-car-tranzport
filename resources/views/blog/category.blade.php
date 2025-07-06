@extends('blog.index')

@section('title', $category->meta_title . ' - Blog')
@section('meta_description', $category->meta_description)
@section('meta_keywords', $category->meta_keywords)

@php
    $currentCategory = $category;
    $featuredPosts = collect(); // No featured posts on category pages
@endphp