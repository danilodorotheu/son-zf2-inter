<?php

namespace SONBase\Mail;

use Zend\Mail\Transport\Smtp as SmtpTransport,
    Zend\Mail\Message,
    Zend\View\Model\ViewModel,
    Zend\Mime\Message as MimeMessage,
    Zend\Mime\Part as MimeParte;

/**
 * Class Mail
 * @package SONBase\Mail
 */
class Mail {
    protected $transport;
    protected $view;
    protected $body;
    protected $message;
    protected $subject;
    protected $to;
    protected $data;
    protected $page;

    /**
     * @param SmtpTransport $transport
     * @param $view
     * @param $page
     */
    public function __construct(SmtpTransport $transport, $view, $page) {
        $this->transport = $transport;
        $this->view = $view;
        $this->page = $page;
    }

    /**
     * @param $subject
     * @return object $this
     */
    public function setSubject($subject) {
        $this->subject = $subject;
        return $this;
    }

    /**
     * @param $to
     * @return object $this
     */
    public function setTo($to) {
        $this->to = $to;
        return $this;
    }

    /**
     * @param array $data
     * @return object $this
     */
    public function setData($data) {
        $this->data = $data;
        return $this;
    }

    /**
     * @param $page
     * @param array $data
     * @return mixed
     */
    public function renderView($page, array $data) {
        $model = new ViewModel();
        $model->setTemplate("mailer/{$page}.phtml");
        $model->setOption('has_parent', true);
        $model->setVariables($data);
        return $this->view->render($model);
    }

    /**
     * @return object $this
     */
    public function prepare() {
        $html = new MimeParte($this->renderView($this->page, $this->data));
        $html->type = 'text/html';
        $html->charset = 'UTF8';
        $body = new MimeMessage();
        $body->setParts(array($html));
        $this->body = $body;
        $config = $this->transport->getOptions()->toArray();
        $this->message = new Message();
        $this->message->addFrom($config['connection_config']['from'])
            ->addTo($this->to)
            ->setSubject($this->subject)
            ->setBody($this->body);
        return $this;
    }

    public function send() {
        $this->transport->send($this->message);
    }

} 