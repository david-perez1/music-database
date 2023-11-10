<!DOCTYPE html>
<html>

<link rel="shortcut icon" type="image/x-icon" href="Music header.ico">

<head>
  <meta charset="UTF-8">

</html>
<link href="allWebApp.css" rel="stylesheet">

<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Login</title>
</head>




<!-- Section: Design Block -->
<section class="background-radial-gradient md:overflow-hidden">
  <style>
    
    .background-radial-gradient {
      background-color: rgb(141, 0, 0);
      background-blend-mode: lighten;
      height: 100%;
      margin: 0;
      padding: 0;
      background-image: url('cougarloginpage.jpeg');
      background-position: center 20%; 
      background-size: 1000px 1000px; 
      background-repeat: no-repeat; 
    }

    @media (min-width: 768px) {
    }
  </style>
  <!-- Navbar -->

  <!-- Navbar -->

  <!-- Jumbotron -->
  <div class="px-6 py-12 text-center md:px-12 lg:py-24 lg:text-left flex md:h-screen items-center justify-center">
    <div class="w-100 mx-auto text-neutral-800 sm:max-w-2xl md:max-w-3xl lg:max-w-5xl xl:max-w-7xl">
      <div class="grid items-center gap-20 lg:grid-cols-2">
        <div class="mt-12 lg:mt-0" style="z-index: 10">
          <h1 class="mt-0 mb-12 text-5xl font-bold tracking-tight md:text-6xl xl:text-7xl text-[hsl(218,81%,95%)]">
            The best place <br /><span class="text-black">to listen to music.</span>
          </h1>
          <p class="opacity-70 text-[hsl(218,81%,85%)]" style="margin-top: -1em;">
          Welcome to Cougify, your music database.
          </p>
        </div>
        <div class="relative mb-12 lg:mb-0" style = "left: 150px;">
          <div id="radius-shape-1" class="absolute rounded-full shadow-lg style=" width: 50px; height: 100px;></div>
          <div id="radius-shape-2" class="absolute shadow-lg" style="width: 100px; height: 100px;"></div>
          <div
            class="bg-blue-200 backdrop-blur-[50px] backdrop-saturate-[200%] block rounded-lg px-6 py-12 md:px-12" style="max-width: 400px; margin-left: 110px; background-color: rgba(30, 30, 30, 1)">
            <form action="Login_Member_Handler.php" method="POST">
              <div class="relative mb-6">
                <div class="pb-2 pt-4">
                  <input type="text" name="username" id="username" placeholder="Enter Username" placeholder="Enter Username"
                    required class="block w-full p-4 text-lg rounded-sm">
                </div>
              </div>
              <div class="relative mb-6">
                <div class="pb-2 pt-4">
                  <input class="block w-full p-4 text-lg rounded-sm" type="password" name="password" id="password"
                    placeholder="Enter Password" required>
                </div>
              </div>
              <button
              class="mb-6 bg-blue-600 inline-block w-full rounded bg-primary px-6 pt-2.5 pb-2 text-xs font-medium uppercase leading-normal text-white shadow-[0_4px_9px_-4px_#3b71ca] transition duration-150 ease-in-out hover:bg-primary-600 hover:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] focus:bg-primary-600 focus:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] focus:outline-none focus:ring-0 active:bg-primary-700 active:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] dark:shadow-[0_4px_9px_-4px_rgba(59,113,202,0.5)] dark:hover:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)] dark:focus:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)] dark:active:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)]">sign
              in</button>

              <div class="flex justify-center pt-2">
                <div class="text-right text-white hover:underline hover:text-white">
                  <a href="Create_Account_Member.html">Create an account</a>
                </div>
              </div>
              <div class="flex justify-center pt-2">
                <div class="text-right text-black hover:underline hover:text-black">
                  <a href="Login_admin.php">Admin Portal</a>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
