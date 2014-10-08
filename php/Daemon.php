<?php

/**
 * PHP 守护进程
 */

declare(ticks = 1);

array_shift($argv);

class Daemon {

	# 子进程退出时会触发这个函数
	public function signal_handler($sig) {
		switch ($sig) {
		case SIGINT:
			posix_kill(0, SIGINT);
			break;
		case SIGCHLD:
			//$this->start($argv);
			break;
		case SIGUSR1:
		}
	}

	# 注册子进程退出的函数
	public function signal($sig, $fn, $restart= true) {
		pcntl_signal($sig, $fn, $restart);
	}

	# 分发
	public function dispatch() {
		pcntl_signal_dispatch();
		return true;
	}

	# 监听
	public function fork() {
		return $pid = pcntl_fork();
	}

	public function alarm($time) {
		pcntl_alarm(5);
	}

	public function start($fn, $count = 1) {

		$pids = array();

		# init childs.
		for ($i = 0; $i < $count; $i++) {

			$pid = $this->fork();

			if ($pid > 0) {
				//$this->signal(SIGALRM, array($this, "signal_handler"), true);
				//$this->signal(SIGUSR1, array($this, "signal_handler"), true);
				$this->signal(SIGCHLD, array($this, "signal_handler"), true);
				$pids[] = $pid;
			}

			if ($pid == 0) {
				break;
			}

		}

		# do sth.
		while (1) {

			if ($pid > 0) {
				$cid = pcntl_waitpid(0, $status, WNOHANG);
				if ($cid > 0) {
					$this->start($fn);
				}
			} else {
				if (function_exists($fn)) {
					$fn();
				}
			}

			sleep(3);
		}

	}

	# 启动子进程
	public function spawn() {
		$pid = $this->fork();

		if ($pid == 0) {

		} else {

		}
	}

}



$d = new Daemon;
$d->start('cbk', 3);

?>
