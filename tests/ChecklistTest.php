<?php

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class ChecklistTest extends TestCase
{
  /**
   * /checklists  [GET]
   */
  public function testShouldReturnAllChecklists()
  {
    $this->get('/checklists', []);
    $this->seeStatusCode(200);
    $this->seeJsonStructure([
      'meta'  => [
        'count',
        'total'
      ],
      'links' => [
        'first',
        'last',
        'next',
        'prev'
      ],
      'data'  =>  [
        '*' =>  [
          'type',
          'id',
          'attributes'  =>  [
            "object_domain",
            "object_id",
            "description",
            "is_completed",
            "due",
            "task_id",
            "urgency",
            "completed_at",
            "last_update_by",
            "updated_at",
            "created_at",
          ],
          'links' =>  [
            'self'
          ]
        ]
      ]
    ]);
  }

  /**
   * /checklists/id [GET]
   */
  public function testShouldReturnChecklist()
  {
    $this->get('/checklists/5', []);
    $this->seeStatusCode(200);
    $this->seeJsonStructure([
      'data'  =>  [
        "type",
        "id",
        "attributes" => [
          "object_domain",
          "object_id",
          "description",
          "is_completed",
          "due",
          "urgency",
          "completed_at",
          "last_update_by",
          "updated_at",
          "created_at",
        ],
        "links" =>  [
          "self",
        ]
      ]
    ]);
  }

  /**
   * /checklists  [POST]
   */
  public function testShouldCreateChecklist()
  {
    $parameters = [
      "data"  =>  [
        "attributes"  =>  [
          "object_domain" =>  "contact",
          "object_id" =>  "1",
          "due" =>  "2019-01-25T07:50:14+00:00",
          "urgency" =>  1,
          "description" =>  "Need to verify this guy house.",
          "task_id" =>  "123"
        ]
      ]
    ];

    $this->post('/checklists', $parameters, []);
    $this->seeStatusCode(201);
    $this->seeJsonStructure([
      "data"  =>  [
        "type",
        "id",
        "attributes"  =>  [
          "object_domain",
          "object_id",
          "task_id",
          "description",
          "is_completed",
          "due",
          "urgency",
          "completed_at",
          "last_update_by",
          "updated_at",
          "created_at",
        ],
        "links" =>  [
          "self"
        ]
      ]
    ]);
  }

  /**
   * /checklists/id [PATCH]
   */
  public function testShouldUpdateChecklist()
  {
    $parameters = [
      "data"  =>  [
        "type"  =>  "checklists",
        "id"  =>  1,
        "attributes"  =>  [
          "object_domain" =>  "contact",
          "object_id" =>  "1",
          "description" =>  "Need to verify this guy house.",
          "is_completed"  =>  false,
          "completed_at"  =>  null,
          "created_at"  =>  "2018-01-25T07:50:14+00:00"
        ],
        "links" =>  [
          "self"  =>  "https://dev-kong.command-api.kw.com/checklists/50127"
        ]
      ]
    ];

    $this->patch('/checklists/5', $parameters, []);
    $this->seeStatusCode(200);
    $this->seeJsonStructure([
      "data"  =>  [
        "type",
        "id",
        "attributes"  =>  [
          "object_domain",
          "object_id",
          "task_id",
          "description",
          "is_completed",
          "due",
          "urgency",
          "completed_at",
          "last_update_by",
          "updated_at",
          "created_at",
        ],
        "links" =>  [
          "self"
        ]
      ]
    ]);
  }

  /**
   * /checklists/id [DELETE]
   */
  public function testShouldDeleteChecklist()
  {
    $this->delete('/checklists/5', [], []);
    $this->seeStatusCode(204);
  }
}
