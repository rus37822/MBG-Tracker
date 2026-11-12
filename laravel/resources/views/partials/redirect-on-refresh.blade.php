<script>
    const navigationEntry = performance.getEntriesByType('navigation')[0];
    const isPageReload = navigationEntry
        ? navigationEntry.type === 'reload'
        : performance.navigation && performance.navigation.type === 1;
    const pagesAllowedOnRefresh = [
        @json(parse_url(route('mbg.form'), PHP_URL_PATH), JSON_UNESCAPED_SLASHES),
        @json(parse_url(route('admin.users.index'), PHP_URL_PATH), JSON_UNESCAPED_SLASHES),
    ];

    if (isPageReload && !pagesAllowedOnRefresh.includes(window.location.pathname)) {
        window.location.replace(@json(route('home')));
    }
</script>
