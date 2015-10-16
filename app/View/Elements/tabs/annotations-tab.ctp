<div class="tab-pane active" id="annotations-tab">        		
<?php if(empty($user_info['Annotation'])): ?>
    <h3>This user hasn't made any annotations yet</h3>
<?php else: ?>
    <table class="table table-striped">
        <tbody><?php foreach($user_info['Annotation'] as $a): ?>
              <tr>
                  <td>
                    <!-- PLACEHOLDER FOR THUMBNAIL -->
                  </td>
                  <td><?php echo $a['resource_name']; ?></td>
                  <td>Resource Type</td>
                  <td><?php echo date('M d, Y', strtotime($a['created'])); ?></td>
                  <td><?php if(isset($a['relation']))
                              echo '<p>Relation</p>';
                            else if (isset($a['transcript']))
                              echo '<p>Transcription</p>';
                            else if (isset($a['url']))
                              echo '<p>URL</p>';
                      ?>
                  </td>
              </tr>
          <?php endforeach; ?></tbody>
    </table>
<?php endif ?>
</div><!-- #annotations-tab -->