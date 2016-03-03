<div class="footer">
    <?php
	echo "<div class='footer-logo'>";
    echo $this->Html->link(
        $this->Html->image('Footer-NEH.svg', array('class' => 'neh')),
        'http://neh.gov',
        array('escape' => false)
    );
    echo $this->Html->link(
        $this->Html->image('Matrix.svg', array('class' => 'matrix')),
        'http://matrix.msu.edu',
        array('escape' => false)
    );
    echo $this->Html->link(
        $this->Html->image('cal-white-masthead.png', array('class' => 'cal')),
        'http://cal.msu.edu',
        array('escape' => false)
    );
	
	// CE Logo, not specified on InvisionApp
    /*echo $this->Html->link(
        $this->Html->image('ce-logo.png', array('class' => 'ce')),
        'http://ce.cal.msu.edu',
        array('escape' => false)
    );*/
	echo "</div>";
	
	echo '<br>';
	echo $this->Html->link(
		$this->Html->image('MSU.svg', array('class' => 'msu')),
		'http://www.msu.edu',
		array('escape' => false)
	);
	
    ?>
	<div class="footer-note">
		<span class="footer-link">
		Call us: (517) XXX-XXXX | 
		<?php echo $this->Html->link('About', '/about') ?> |
		<?php echo $this->Html->link('Home', '/') ?> |
		<?php echo $this->Html->link('Search', '/search') ?> |
		<?php echo $this->Html->link('Help', '/help') ?> |
		<?php echo $this->Html->link('Login', '/#loginModal') ?>
		</span>
		<br>
		<span class="footer-misc">
		Call MSU <span class="footer-contact">(517) 355-1855</span> | 
		Visit <a class="footer-contact" href="http://www.msu.edu">MSU.EDU</a> | 
		MSU is an affirmative-action, equal-opportunity employer.
		</span>
		<br>
		<span class="footer-misc">
			<span>SPARTAN WILL</span> |
			&copy; Michigan State University Board of Trustees
		</span>
	</div>

	<!-- Original Footer disclaimer and links, doesn't match InvisionApp
	
		<br>
		<span class="disclaimer">
			Any views, findings, conclusions, or recommendations expressed in this website do not necessarily represent those of the National Endowment for the Humanities or Michigan State University.
		</span>
		<hr>
		<?php echo $this->Html->link('About', '/about') ?> /
		<?php echo $this->Html->link('Home', '/') ?> /
		<?php echo $this->Html->link('Search', '/search') ?> /
		<?php echo $this->Html->link('Help', '/help') ?> /
		<?php echo $this->Html->link('Login', '/#loginModal') ?>
		&nbsp;&nbsp;
		&copy; 2012-2013 Michigan State University Board of Trustees
	-->