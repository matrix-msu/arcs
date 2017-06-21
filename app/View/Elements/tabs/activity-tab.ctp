<div class="tab-pane" id="activity-tab">
<?php if(empty($user_info['Activity'])): ?>
<div id="contents">
    <h3>This user has no activity</h3>
</div>
<?php else: ?>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Type</th>
                <th>For</th>
                <th>Content <i class="icon icon-question-sign" rel="tooltip" title="This will either be a link to another resource, a transcription of a section of a resource, or a link to a page outside ARCS "</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody><?php foreach($user_info['Activity'] as $a): ?>
              <tr>
                  <td>
                  <!-- TO DO: ADD THE CODE FOR DISPLAYING WHAT AN ACTIVITY CORRESPONDS TO -->
                    <i class="<?php if(isset($a['relation']))
                                      echo 'icon-retweet" rel="tooltip" title="Relation';
                                    else if(isset($a['transcript']))
                                      echo 'icon-align-left" rel="tooltip" title="Transcript';
                                    else if(isset($a['url']))
                                      echo 'icon-share" rel="tooltip" title="Outside URL';
                                    else
                                      echo 'icon-question-sign" rel="tooltip" title="Type Unknown" target="_blank';
                              ?>"></i>
                  </td>

                  <td><?php echo $this->Html->link($a['resource_id'],
                      '/resource/' . $a['resource_id']); ?></td>
                  <td>
                    <?php if(isset($a['relation'])) : ?>
                          <?php echo $this->Html->link($a['relation'],
                      '/resource/' . $a['relation']); ?>

                    <?php elseif(isset($a['transcript'])) : ?>

                            <p><?php echo $a['transcript']; ?></p>

                        <?php elseif(isset($a['url'])) : ?>

                          <a href="<?php echo $a['url']; ?>"
                            ><?php echo $a['url']; ?></a>

                    <?php endif; ?>

                  </td>

                  <!-- date --><td><?php echo $a['created']; ?></td>
              </tr>
          <?php endforeach; ?></tbody>
    </table>
<?php endif ?>
<div class="container"><div id="paginate">
	<ul class="pagination">
		<div id='rightArrowBox' style="display:none"><li id='rightArrow' class='pointerDown pointerNum'></li></div>

		<li><a class='pageNumber' id='firstPage' style="display:none"> 1 </a></li>
		<div id='fDots'><li class='fDots' style="display:none"> ... </li></div>
		<li><a class='selected currentPage pageNumber' id='1' style="display:none"></a></li>
		<li><a class='pageNumber' id='2'style="display:none" ></a></li>
		<li><a class='pageNumber' id='3' style="display:none"></a></li>
		<li><a class='pageNumber' id='4' style="display:none"></a></li>
		<li><a class='pageNumber' id='5' style="display:none"></a></li>
		<div id='dots'> <li class='dots' style="display:none" style="display:none"> ... </li></div>
		<li><a class='pageNumber' id="lastPage" style="display:none"></a></li>
		<div id="leftArrowBox" style="display:none"><li id='leftArrow' class='pointerDown pointerNum'></li></div>
	</ul>
</div></div>
</div>
