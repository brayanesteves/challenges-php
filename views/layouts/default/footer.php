

    <script src="https://kit.fontawesome.com/a81368914c.js"></script> 
    <?php if(isset($_layoutParams['libsjscss']) && count($_layoutParams['libscssjs'])): ?>
    <?php for($i = 0; $i < count($_layoutParams['libsjscss']); $i++): ?>
    <?php if(pathinfo($_layoutParams['libsjscss'][$i], PATHINFO_EXTENSION) == "js"): ?>
    <script src="<?php echo $_layoutParams['libsjscss'][$i]; ?>" extension="<?php echo pathinfo($_layoutParams['libsjscss'][$i], PATHINFO_EXTENSION); ?>"></script>
    <?php endif; ?>
    <?php endfor; ?>
    <?php endif; ?>  
    <?php if(isset($_layoutParams['libsjs']) && count($_layoutParams['libsjs'])): ?>
    <?php for($i = 0; $i < count($_layoutParams['libsjs']); $i++): ?>
    <script src="<?php echo $_layoutParams['libsjs'][$i]; ?>"></script>
    <?php endfor; ?>
    <?php endif; ?>
    <?php if(isset($_layoutParams['js']) && count($_layoutParams['js'])): ?>
    <?php for($i = 0; $i < count($_layoutParams['js']); $i++): ?>
    <script src="<?php echo $_layoutParams['js'][$i]; ?>"></script>
    <?php endfor; ?>
    <?php endif; ?>
    <script src="<?php echo $_layoutParams['root_js'] . 'main.js'; ?>"></script>
</body>
</html>