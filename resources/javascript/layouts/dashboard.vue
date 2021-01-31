<template>    
  	<div class="dashboard">
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light fixed-top" style="background-color: #fff !important;">
    <div class="container">
        <a class="navbar-brand" href="#">WebApp</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
            </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
        <ul class="navbar-nav ml-auto">
            <li class="nav-item active">
                <a class="nav-link" href="#">Dashboard
                    <span class="sr-only">(current)</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#/dashboard/subindex">SubDashboard</a>
            </li>   
            <li class="nav-item">
                <a class="nav-link" href="#/login">Login</a>
            </li>          
        </ul>
        </div>
    </div>
    </nav>

    <div class="container h-100">
        <div class="row h-100 align-items-center">
        <router-view></router-view>     
        </div>
    </div>
    
    </div>
</template>