<?php

namespace MagicLink\Actions;

class ViewAction implements ActionInterface
{
    protected $view;

    protected $data;

    protected $mergeData;

    /**
     * Constructor action.
     *
     * @param string $view
     * @param \Illuminate\Contracts\Support\Arrayable|array $data
     * @param array $mergeData
     */
    public function __construct(string $view, $data = [], $mergeData = [])
    {
        $this->view = $view;

        $this->data = $data;

        $this->mergeData = $mergeData;
    }

    /**
     * Execute Action.
     */
    public function run()
    {
        return view($this->view, $this->data, $this->mergeData);
    }
}
