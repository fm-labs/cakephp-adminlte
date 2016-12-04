<?php

namespace AdminLte\View\Helper;


use Bootstrap\View\Helper\ContentBlockHelperTrait;
use Cake\View\Helper;
use Cake\View\StringTemplateTrait;

class BoxHelper extends Helper
{
    public $helpers = ['Html'];

    use StringTemplateTrait;
    use ContentBlockHelperTrait;

    /**
     * Default config for this class
     *
     * @var array
     */
    protected $_defaultConfig = [
        'templates' => [
            'box' => '<div class="box box-default{{collapsedClass}}">{{header}}{{body}}</div>',
            'boxHeader' => '<div class="box-header with-border">{{title}}{{tools}}</div>',
            'boxTitle' => '<h3 class="box-title">{{title}}</h3>',
            'boxTools' => '<div class="box-tools pull-right">{{tools}}</div>',
            'boxBody' => '<div class="box-body">{{contents}}</div>',
            'boxToolCollapseButton' => '<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>',
            'boxToolExpandButton' => '<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i></button>'
        ],
    ];


    protected $_defaultParams = [
        'id' => null,
        'autostart' => true,
        'collapsed' => false,
        'collapse' => true,
        'expand' => true
    ];

    //protected $_id;
    protected $_params = [];


    public function create($title = null, $params = []) {

        $this->clean();

        if (is_array($title)) {
            $params = $title;
            $title = null;
        }

        $params['title'] = $title;

        $this->_params = array_merge($this->_defaultParams, $params);
        //$this->_id = ($this->_params['id']) ?: uniqid('box');

        if ($this->_params['autostart']) {
            $this->start();
        }
    }

    public function heading() {
        $this->start('heading');
    }

    public function body() {
        $this->start('body');
    }

    public function render()
    {
        $this->end();
        return $this->templater()->format('box', [
            'collapsedClass' => ($this->_params['collapsed']) ? ' collapsed-box' : '',
            'header' => $this->_renderHeader(),
            'body' => $this->_renderBody()
        ]);
    }

    protected function _renderHeader()
    {
        return $this->templater()->format('boxHeader', [
            'title' => $this->_renderTitle(),
            'tools' => $this->_renderTools(),
        ]);
    }

    protected function _renderTitle()
    {
        $title = ($this->getContent('heading')) ?: $this->_params['title'];
        return $this->templater()->format('boxTitle', ['title' => $title]);
    }

    protected function _renderBody()
    {
        return $this->templater()->format('boxBody', ['contents' => $this->getContent('body')]);
    }

    protected function _renderTools()
    {
        $tools = '';

        if ($this->_params['collapse']) {
            $collapseTempl = ($this->_params['collapsed']) ? 'boxToolExpandButton' : 'boxToolCollapseButton';
            $tools .= $this->templater()->format($collapseTempl, []);
        }
        return $this->templater()->format('boxTools', ['tools' => $tools]);
    }


    /**
     * <div class="box box-default">
    <div class="box-header with-border">
    <h3 class="box-title">Collapsable</h3>
    <div class="box-tools pull-right">
    <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
    </div><!-- /.box-tools -->
    </div><!-- /.box-header -->
    <div class="box-body">
    The body of the box
    </div><!-- /.box-body -->
    </div><!-- /.box -->
     */
}