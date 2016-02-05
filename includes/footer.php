<footer id="footer">
    <?php
        $time_end = microtime(true);
        $time = $time_end - $time_start;
        $page_load_time = number_format($time, 3, ',', ' ');

        echo '<br>'.$title_project.' v'.$version_project.' - Page générée en ' . $page_load_time . ' sec.';

    ?>
    <br><br>
</footer>
</body>
</html>