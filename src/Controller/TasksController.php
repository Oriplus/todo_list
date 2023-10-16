<?php

namespace App\Controller;

use App\Controller\AppController;

/**
 * Tasks Controller
 *
 * @property \App\Model\Table\TasksTable $Tasks
 *
 * @method \App\Model\Entity\Task[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class TasksController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Statuses'],
        ];
        $tasks = $this->paginate($this->Tasks);
        return $this->setJsonResponse(
            [
                'data' => $tasks,
                'status' => 'success',
            ],
            200
        );
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response 
     */
    public function add()
    {
        $data = $this->request->getData();
        $data['status_id'] = 1;
        $task = $this->Tasks->newEntity();
        $task = $this->Tasks->patchEntity($task, $data, [
            'validate' => true,
            'fields' => ['description', 'status_id'],
            'context' => ['method' => 'add']
        ]);
        $result = $this->Tasks->save($task);
        if ($result !== false) {
            return $this->setJsonResponse(
                [
                    'data' => $result,
                    'status' => 'success',
                    'message' => 'The task has been created.',
                ],
                201
            );
        }
        return $this->setJsonResponse(
            [
                'errors' => $task->getErrors(),
                'message' => 'The task could not be created. Please, try again.',
            ],
            422
        );
    }

    /**
     * Edit method
     *
     * @param string $id Task id.
     * @return \Cake\Http\Response
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id)
    {
        $task = $this->Tasks->get($id);
        $task = $this->Tasks->patchEntity($task, $this->request->getData(), [
            'validate' => true,
            'fields' => ['description'],
            'context' => ['method' => 'edit']
        ]);
        $result = $this->Tasks->save($task);
        if ($result !== false) {
            return $this->setJsonResponse(
                [
                    'data' => $result,
                    'status' => 'success',
                    'message' => 'The task has been updated.',
                ],
                200
            );
        }
        return $this->setJsonResponse(
            [
                'errors' => $task->getErrors(),
                'message' => 'The task could not be updated. Please, try again.',
            ],
            422
        );
    }

    /**
     * Delete method
     *
     * @param string $id Task id.
     * @return \Cake\Http\Response
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id)
    {
        $task = $this->Tasks->get($id);
        $result = $this->Tasks->delete($task);
        if ($result !== false) {
            return $this->setJsonResponse(
                [
                    'status' => 'success',
                    'message' => 'The task has been deleted.',
                ],
                204
            );
        }
    }

    /**
     * Update status method
     *
     * @param string $id Task id.
     * @return \Cake\Http\Response
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function updateStatus($id)
    {
        $task = $this->Tasks->get($id);
        $task = $this->Tasks->patchEntity($task, $this->request->getData(), [
            'validate' => true,
            'fields' => ['status_id'],
            'context' => ['method' => 'updateStatus']
        ]);
        $result = $this->Tasks->save($task);
        if ($result !== false) {
            return $this->setJsonResponse(
                [
                    'data' => $result,
                    'status' => 'success',
                    'message' => 'The status has been updated.',
                ],
                200
            );
        }

        return $this->setJsonResponse(
            [
                'errors' => $task->getErrors(),
                'message' => 'The status could not be updated. Please, try again.',
            ],
            422
        );
    }

    /**
     * Json response formater
     *
     * @param array $data
     * @return \Cake\Http\Response
     */
    private function setJsonResponse($data, $statusCode = 200)
    {
        return $this->response
            ->withType('application/json')
            ->withStatus($statusCode)
            ->withStringBody(json_encode($data));
    }
}
