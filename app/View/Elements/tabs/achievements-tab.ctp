<style media="screen">
.badges ul {
  width: 100%;
  text-align: center;
  margin-top: 20px;
}
.badges li {
  width: 200px;
  height: 200px;
  display: inline-table;
  position: relative;
  margin: 26px;
}
.badges .a-value{
  position: absolute;
  font-size: 40px;
  width: 56px;
  height: 56px;
  text-align: center;
  top: 16px;
  left: 16px;
  color: white;
}
.a-info{
  text-align: center;
  margin-top: 20px;
}
.a-name{
  margin-bottom: 20px;
  font-size: 20px;
}
.a-description {
  font-size: 14px;
}
</style>
<div class="tab-pane" id="achievements-tab">
  <article class="badges">
    <ul>
      <?php
      for ($i=0; $i < (int)$user_info['commentsInitiatedBadges']; $i++) {
        echo $this->Achievement->getAchievement(Achievement::InitiatedDiscustion, 10);
      }
      for ($i=0; $i < (int)$user_info['commentsRepliedBadges']; $i++) {
        echo $this->Achievement->getAchievement(Achievement::DiscussionResponse, 10);
      }
      for ($i=0; $i < (int)$user_info['annotationsInBadges']; $i++) {
        echo $this->Achievement->getAchievement(Achievement::AnnotationInSystem, 10);
      }
      for ($i=0; $i < (int)$user_info['annotationsOutBadges']; $i++) {
        echo $this->Achievement->getAchievement(Achievement::AnnotationOutSystem, 10);
      }
      ?>
    </ul>
  </article>

</div><!-- #achievements-tab -->
