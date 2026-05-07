<script>
    document.addEventListener('alpine:init', () => {
        Alpine.store('sidebar', {
            open: false,
            collapsed: JSON.parse(localStorage.getItem('jetax-sidebar-collapsed') || 'false'),
            toggle() {
                this.collapsed = !this.collapsed;
                localStorage.setItem('jetax-sidebar-collapsed', JSON.stringify(this.collapsed));
            }
        });
    });
</script>
