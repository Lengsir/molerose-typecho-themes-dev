<?php function threadedComments($comments, $options) {
    $commentClass = '';
    if ($comments->authorId) {
        if ($comments->authorId == $comments->ownerId) {
            $commentClass .= ' comment-by-author';
        } else {
            $commentClass .= ' comment-by-user';
        }
    }
 
    $commentLevelClass = $comments->levels > 0 ? ' comment-child' : ' comment-parent';
?>
 
<li id="li-<?php $comments->theId(); ?>" class="comment-body<?php 
if ($comments->levels > 0) {
    echo ' comment-child';
    $comments->levelsAlt(' comment-level-odd', ' comment-level-even');
} else {
    echo ' comment-parent';
}
$comments->alt(' comment-odd', ' comment-even');
echo $commentClass;
?>">

    <div class="comment-txt-box" id="<?php $comments->theId(); ?>">
        <div class="comment-author clearfix">
            <?php $comments->gravatar('40', ''); ?>
            <cite class="fn comment-info-title"><?php $comments->author(); ?></cite>
            <span class="comment-meta" ><?php $comments->date('F jS, Y \a\t h:i a'); ?></span>
        </div>

        <?php $comments->content(); ?>

        <?php if ('waiting' == $comments->status) { ?>  
        <em class="awaiting"><?php $options->commentStatus(); ?></em>  
        <?php } ?>
        <!-- 评论审核，waiting 后全等的对象，对应 threadedComments 的第一，二个对象 -->
        <div class="comment-meta">
            <span class="comment-reply label bg-info"><?php $comments->reply(); ?></span>
        </div>
    </div>
<?php if ($comments->children) { ?>
    <div class="comment-children">
        <?php $comments->threadedComments($options); ?>
        
    </div>
<?php } ?>
</li>
<?php } ?>

<!-- comments Begin -->
<section id="comments">

 <?php $this->comments()->to($comments); ?>
 <?php if ($comments->have()): ?>

<h4 class="m-t-lg m-b"><?php $this->commentsNum(_t('暂无评论'), _t('仅有一条评论'), _t('已有 %d 条评论')); ?></h4> 

<?php $comments->listComments(); ?>

<?php endif; ?>

<div class="text-center"> 
<?php $comments->pageNav('«', '»', 3, '...', array('wrapTag' => 'ul', 'wrapClass' => 'pagination pagination-sm', 'itemTag' => 'li', 'textTag' => 'a', 'currentClass' => 'active', 'prevClass' => '', 'nextClass' => '')); ?>
</div> 

<?php if($this->allow('comment')): ?>
<section id="<?php $this->respondId(); ?>" class="respond">

<div class="cancel-comment-reply">
        <?php $comments->cancelReply(); ?>
</div>

<h4 class="m-t-md m-b" id="response"><?php _e('发表评论'); ?></h4>

<form method="post" action="<?php $this->commentUrl() ?>" id="comment-form" role="form" > 
    <div class="form-group"> 
    <label><?php _e('评论'); ?> <em class="form-bt">*</em></label> 
    <textarea rows="5" cols="50" name="text" id="textarea" class="form-control OwO-textarea" placeholder="<?php _e('在这里输入您的想法...'); ?>" required ><?php $this->remember('text'); ?></textarea>
     <div title="OwO" class="OwO"></div> 
    </div> 
    <?php if($this->user->hasLogin()): ?>
       <p><?php _e('欢迎'); ?> <a href="<?php $this->options->profileUrl(); ?>"><?php $this->user->screenName(); ?></a> <?php _e('归来'); ?>. <a href="<?php $this->options->logoutUrl(); ?>" title="Logout"><?php _e('退出'); ?> &raquo;</a></p>
    <?php else: ?>
    <div class="form-group pull-in clearfix"> 
    <div class="col-sm-4"> 
     <label for="author"><?php _e('名称'); ?> <em class="form-bt">*</em></label> 
     <input type="text" name="author" id="author" class="form-control" placeholder="<?php _e('姓名或者昵称'); ?>" value="<?php $this->remember('author'); ?>" required /> 
    </div> 
    <div class="col-sm-4"> 
     <label for="mail"<?php if ($this->options->commentsRequireMail): ?> class="required"<?php endif; ?>><?php _e('邮箱'); ?> <em class="form-bt">*</em></label> 
     <input type="mail" name="mail" id="mail" class="form-control" placeholder="<?php _e('邮箱（将为您保密）'); ?>" value="<?php $this->remember('mail'); ?>"<?php if ($this->options->commentsRequireMail): ?> required<?php endif; ?> /> 
    </div> 
    <div class="col-sm-4"> 
     <label for="url"<?php if ($this->options->commentsRequireURL): ?> class="required"<?php endif; ?>><?php _e('地址'); ?></label> 
     <input type="url" name="url" id="url" class="form-control" placeholder="<?php _e('http://'); ?>" value="<?php $this->remember('url'); ?>"<?php if ($this->options->commentsRequireURL): ?> required<?php endif; ?> /> 
    </div>

    </div> 
    <?php endif; ?>

    <div class="form-group"> 
    <button type="submit" class="btn btn-success"><?php _e('发表评论'); ?></button> 
    </div> 
</form>
</section>
 <?php else: ?>
    <h3><?php _e('评论已关闭'); ?></h3>
<?php endif; ?>

</section>

<!-- OWO 表情 -->
<script>
var OwO_demo = new OwO({
    logo: 'OωO表情',
    container: document.getElementsByClassName('OwO')[0],
    target: document.getElementsByClassName('OwO-textarea')[0],
    api: '/usr/themes/molerose/js/OwO.min.json',
    position: 'down',
    width: '100%',
    maxHeight: '250px'
});
</script>
