<div class="tab-pane" id="discussion-tab">
<?php if(empty($user_info['Comment'])): ?>
<div id="contents">
    <h3>No discussion items</h3>
</div>
<?php else: ?>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Content</th>
                <th>For</th>
                <th>Author</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach($user_info['Comment'] as $comment): ?>
            <tr>
                <td><?php echo $comment['content']; ?></td>
                <td><?php echo $this->Html->link($comment['resource_id'],
                    '/resource/' . $comment['resource_id']); ?></td>
                <td><?php echo $user_info['User']['name']; ?></td>
                <td><?php echo $comment['created']; ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
<?php  endif; ?>
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
