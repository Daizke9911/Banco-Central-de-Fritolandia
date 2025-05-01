@if (session('message'))
        <script>
            Swal.fire({
            title: "{{session('message')}}",
            text: "",
            icon: "success"
            });
        </script>
@endif
@if (session('error'))
        <script>
            Swal.fire({
            icon: "error",
            title: "{{session('error')}}",
            text: "",
            });
        </script>
@endif
@if (session('success'))
        <script>
            Swal.fire({
            title: "{{session('success')}}",
            text: "",
            icon: "success"
            });
        </script>
@endif
@if (session('security'))
        <script>
            Swal.fire({
            icon: "error",
            title: "{{session('security')}}",
            text: "",
            });
        </script>
@endif
@if (session('credentials'))
        <script>
            Swal.fire({
            icon: "error",
            title: "{{session('credentials')}}",
            text: "",
            });
        </script>
@endif
@if (session('expired'))
        <script>
            Swal.fire("{{session('expired')}}");
        </script>
@endif



