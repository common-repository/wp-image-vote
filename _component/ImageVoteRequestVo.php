<?php
/**
 * Image Vote Value Object Class
 *
 * @copyright   
 * @link        
 * @package     WP Image Vote
 * @version     
 */
class ImageVoteRequestValueObject {

    var $params = array();

    /**
     * setParam
     */
    function setParam($name, $value) {
        $this->params[$name] = $value;
    }

    /**
     * getParam
     */
    function getParam($name) {
        return $this->params[$name];
    }
}

class ImageVoteRequestVo extends ImageVoteRequestValueObject {
    /**
     * The Constructor
     */
    function ImageVoteRequestVo() {
        if (is_array($_REQUEST)) {
            foreach($_REQUEST as $name => $value) {
                $this->setParam($name, $value);
            }
        }
    }
}
