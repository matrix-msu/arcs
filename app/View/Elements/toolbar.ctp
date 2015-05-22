<div id="toolbar" class="row">
    <?php if (!isset($logo) || $logo): ?>
        <a id="logo-wrapper" href="<?php echo $this->Html->url('/') ?>">
            <h1 id="logo">
                <?php echo isset($logo) && is_string($logo) ? $logo : "ARCS" ?>
            </h1>
        </a>
    <?php endif ?>
    <?php if ($user['loggedIn']): ?>
    <div id="menu" class="btn-group toolbar-btn">
        <button id="menuButton" class="btn btn-dark">
            <?php echo $user['name'] ?> 
            <span class="pointerDown"></span>
        </button>
        <div id="droppedMenu" class="dropped-menu">
            <?php echo $this->Html->link('Profile', 
                '/user/' . $user['username']) ?>
            <?php if ($user['role'] === 0): ?>
            <?php echo $this->Html->link('Admin', 
                '/admin') ?>
            <?php endif ?>
            <?php echo $this->Html->link('Sign Out', 
                '/logout') ?>
        </div>
    </div>
    <?php else: ?>
    <a class="btn btn-dark toolbar-btn" 
        href="<?php echo $this->Html->url('/login') ?>">Login / Register</a>
    <?php endif ?>
    <div class="btn-group toolbar-btn">
        <?php if ($user['loggedIn']): ?>
        <a id="upload" class="btn btn-grey"
            href="<?php echo $this->Html->url('/upload')?>">
            <i class="icon-white icon-upload"></i> Upload
        </a>
        <?php endif ?>
        <a id="about" class="btn btn-grey"
            href="<?php echo $this->Html->url('/about')?>">
            <i class="icon-white icon-folder-open"></i> About
        </a>
         <a id="resources" class="btn btn-grey"
            href="<?php echo $this->Html->url('/resources')?>">
            <i class="icon-white icon-folder-open"></i> Resources
        </a>
        <a id="collections" class="btn btn-grey"
            href="<?php echo $this->Html->url('/collections')?>">
            <i class="icon-white icon-folder-open"></i> Collections
        </a>
        <a id="search" class="btn btn-grey"
            href="<?php echo $this->Html->url('/search')?>">
            <i class="icon-white icon-search"></i> Search
        </a>
        <a id="help" class="btn btn-grey"
            href="<?php echo $this->Html->url('/help/')?>">
            <i class="icon-white icon-book"></i> Help
        </a>
    </div>
</div>