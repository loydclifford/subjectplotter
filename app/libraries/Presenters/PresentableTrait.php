<?php

trait PresentableTrait
{

    /**
     * View presenter instance
     *
     * @var mixed
     */
    protected $presenterInstance;

    /**
     * Prepare a new or cached presenter instance
     *
     * @return mixed
     * @throws PresenterException
     */
    public function present()
    {
        if (! $this->presenter)
        {
            throw new PresenterException('Please set the $presenter property to your presenter path.');
        }
        else if (! class_exists($this->presenter))
        {
            echo '<pre><dd>'.var_export($this->presenter, true).'</dd></pre>';
            die();
            throw new PresenterException('The value of $presenter class does not exists.');
        }

        if (! $this->presenterInstance)
        {
            $this->presenterInstance = new $this->presenter($this);
        }

        return $this->presenterInstance;
    }
}
