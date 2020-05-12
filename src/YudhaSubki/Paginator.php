<?php

namespace YudhaSubki;

class Paginator
{
    /**
     * Set Base URL
     * 
     * @var string
     */
    protected $url;

    /**
     * Length of number prev
     * 
     * @var int
     */
    protected $prevLength;

    /**
     * Length of number next
     * 
     * @var int
     */
    protected $nextLength;
    
    /**
     * Current Page
     * 
     * @var int
     */
    protected $currentPage;

    /**
     * Number Previous
     * 
     * @var int
     */
    protected $numberPrevious;

    /**
     * Number next
     * 
     * @var int
     */
    protected $numberNext;

    /**
     * Total Page
     * 
     * @var int
     */
    protected $totalPage;

    /**
     * Page length
     * 
     * @var int
     */
    protected $pageLength;

    /**
     * Custom Template
     * 
     * @var String
     */
    protected $customTemplate;

    /**
     * Default list template
     * 
     * @var string
     */
    protected const DEFAULT_LIST_TEMPLATE = '<li class="page-item %s"><a class="page-link" href="%s">%s</a></li>';

    /**
     * Query Options
     * 
     * @var array
     */
    protected $options;

    public function __construct($totalPage, $url, $currentPage, $options = [], $prevLength = 2, $nextLength = 2)
    {
        $this->totalPage   = $totalPage;
        $this->url         = $url;
        $this->currentPage = (int) $currentPage;
        $this->options     = (array) $options;
        $this->prevLength  = $prevLength;
        $this->nextLength  = $nextLength;
    }

    /**
     * Template to generate list of pagination number
     * 
     * @param int 
     * @param bool
     * @return string
     */
    public function numberTemplate($number = 1, $isCurrent = false, $withoutNumber = null) : string
    {
        $template = $this->customTemplate != '' || !is_null($this->customTemplate) ? $this->customTemplate : self::DEFAULT_LIST_TEMPLATE;
        return sprintf($template, 
                        $isCurrent == true ? "active disabled" : "",
                        $this->url($number),
                        is_null($withoutNumber) ? $number : $withoutNumber
                    );
    }

    /**
     * You can create custom template list of pagination
     * Ex Template : <li class="page-item %s"><a class="page-link" href="%s">%s</a></li>
     * Don't forget set 3 parameters to present class disabled, anchor link, and number string
     * 
     * @param String | Custom Template
     */
    public function setCustomTemplate($customTemplate = '') 
    {
        $this->customTemplate = $customTemplate;
        return $this;
    }

    /**
     * Genarate the previous number pagination 
     * 
     * @param int
     * @return array
     */
    public function previous($numberPrevious) : array
    {
        $templates = [];
        $startedPage = $numberPrevious >= $this->prevLength ? $this->currentPage - $this->prevLength : 1 ;
        $previousPage = $this->currentPage == 1 ? 1 : $this->currentPage - 1;
        $templates[] = $this->numberTemplate($previousPage, $this->currentPage == 1 ? true : false, 'Previous');
        while($startedPage <= $numberPrevious)
        {
            $templates[] = $this->numberTemplate($startedPage, false);
            $startedPage++;
        }

        return $templates;
    }

    /**
     * Genarate the next number pagination 
     * 
     * @param int
     * @return array
     */
    public function next($numberNext)
    {
        $templates = [];
        
        $midPage = $this->currentPage + 1;
        while($midPage <= $numberNext)
        {
            $templates[] = $this->numberTemplate($midPage, false);
            $midPage++;
        }
        $nextPage = $this->currentPage + 1;
        $templates[] = $this->numberTemplate($nextPage , $nextPage <= $numberNext ? false : true, 'Next');

        return $templates;
    }

    /**
     * Genarate current number pagination 
     * 
     * @return array
     */
    public function current() : string
    {
        return $this->numberTemplate($this->currentPage, true);
    }

    /**
     * Set URL in list of pagination
     * 
     * @param int
     * @return Route
     */
    public function url($page = 1)
    {
        if(!empty($this->options)){
            $this->options['page'] = $page;
        }

        return sprintf($this->url.'?%s', \http_build_query(empty($this->options) ? 
                            ['page' => $page] : 
                            $this->options
                        ));
    }

    /**
     * Render or display all pagination list number
     * 
     * @return array
     */
    public function render() : array
    {
        if($this->currentPage - 1 >= 1) {
            $this->numberPrevious = $this->currentPage > 2 ? 
                $this->currentPage - 1 : 1;
        }

        if($this->totalPage - $this->currentPage >= 1) {
            $this->numberNext = ($this->totalPage - $this->currentPage) >= 2 ?
                $this->currentPage + $this->nextLength : 
                ($this->totalPage - $this->currentPage) + $this->currentPage;
        }
    
        $prevTemplate    = $this->previous($this->numberPrevious);
        $nextTemplate    = $this->next($this->numberNext);
        $currentTemplate = $this->current();
        return $this->generate($prevTemplate, $currentTemplate, $nextTemplate);
    }

    /**
     * Compose to list to array of string
     * 
     * @param array|variadic
     * @return array
     */
    public function generate(...$templates) : array
    {
        $html = [];
        foreach($templates as $template)
        {
            if(is_array($template)){
                if(count($template) > 0) {
                    foreach($template as $t){
                        $html[] = $t;
                    }
                }
                continue;
            }
            $html[] = $template;
        }

        return $html;
    }
}