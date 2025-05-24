<script>
    window.sidebar = "{{ Auth::user()->tema->sidebar ?? null }}";
    window.buttonSidebar = "{{ Auth::user()->tema->button_sidebar ?? null }}";
    window.textColorSidebar = "{{ Auth::user()->tema->text_color_sidebar ?? null }}";
    window.background = "{{ Auth::user()->tema->background ?? null }}";
</script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="{{asset('js/theme.js')}}"></script>
<script src="https://cdn.jsdelivr.net/gh/Daizke9911/estilosBCF@master/js/theme.js"></script>
