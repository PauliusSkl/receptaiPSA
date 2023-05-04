<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('User dashboard') }}
        </h2>
    </x-slot>
    @if (session('error'))
        <div class="alert alert-danger" role="alert">
            {{ session('error') }}
        </div>
    @endif

    <h1>Countdown Timer</h1>
    <p>Redirecting in <span id="timer"></span> seconds...</p>

    <form action="/user/start_making/{{ $recipe->id }}" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="file" name="photo" id="photo">
        <input type="submit" value="Finish early" class="btn btn-danger">
    </form>
    <script>
        // Set the countdown time in seconds
        const countdownTime = {{ $timeleft }};

        // Set the redirect URL
        const redirectUrl = "/user/start_making/{{ $recipe->id }}";

        // Get the timer element
        const timerElement = document.getElementById("timer");

        // Start the countdown
        let countdown = countdownTime;
        const countdownInterval = setInterval(() => {
            countdown--;
            timerElement.textContent = countdown;

            // Redirect when the countdown reaches zero
            if (countdown === 0) {
                clearInterval(countdownInterval);

                // Create a form element and submit it with a POST request
                const form = document.createElement("form");
                form.method = "POST";
                form.action = redirectUrl;
                document.body.appendChild(form);
                form.submit();
            }
        }, 1000);
    </script>

</x-app-layout>
