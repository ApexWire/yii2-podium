<?php

namespace bizley\podium\widgets\poll;

use bizley\podium\models\Poll as PollModel;
use bizley\podium\models\Thread;
use bizley\podium\models\User;
use yii\base\Widget;
use yii\bootstrap\ActiveForm;

/**
 * Podium Poll widget
 * Create new poll and renders votes and results.
 * 
 * @author Paweł Bizley Brzozowski <pawel@positive.codes>
 * @since 0.5
 */
class Poll extends Widget
{
    /**
     * @var PollModel
     */
    public $model;


    /**
     * Rendering the poll.
     * @return string
     */
    public function run()
    {
        if (!$this->model) {
            return null;
        }
        $hidden = $this->model->hidden;
        if ($hidden && !empty($this->model->end_at) && $this->model->end_at < time()) {
            $hidden = 0;
        }        
        return $this->render('view', [
            'model' => $this->model,
            'hidden' => $hidden,
            'voted' => $this->model->getUserVoted(User::loggedId())
        ]);
    }
    
    /**
     * Renders poll creation form.
     * @param ActiveForm $form
     * @param Thread $model
     * @return string
     */
    public static function create($form, $model)
    {
        return (new static)->render('create', ['form' => $form, 'model' => $model]);
    }
    
    /**
     * Returns rendered preview of the poll.
     * @param Thread $model
     * @return string
     */
    public static function preview($model)
    {
        if (!$model->poll_added) {
            return null;
        }
        return (new static)->render('preview', ['model' => $model]);
    }
}
