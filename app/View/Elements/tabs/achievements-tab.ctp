<div class="tab-pane" id="achievements-tab">        		
<?php if(empty($user_info['Achievement'])): ?>
    <h3>This user hasn't had any achievements yet</h3>
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
        <tbody><?php foreach($user_info['Achievement'] as $a): ?>
              <tr>
              <!-- TO DO: CORRECT THIS TO ACTUALLY MATCH WHAT AN ACHIEVEMENT CORRESPONDS TO -->
                  <td>
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
</div><!-- #achievements-tab -->