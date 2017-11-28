  <li data-menu="">

                  <ul data-menu="">
                      <li data-menu="dropdown" class="dropdown nav-item">
                          <a href="#" data-toggle="dropdown" class="navbar-fixed">
                              <i class="icon-money2"></i> {{__('top_menu.expenses')}}
                          </a>
                          <ul class="dropdown-menu">
                              <li data-menu="">
                                  <a href="{{ route('manager.expenses.index') }}" data-toggle="dropdown" class="dropdown-item">
                                      <i class="icon-money"></i>{{__('top_menu.expenses_list')}}
                                  </a>
                              </li>
                              <li data-menu="">
                                  <a href="{{ route('manager.expenses.types.index') }}" data-toggle="dropdown" class="dropdown-item">
                                      <i class="icon-coin-dollar"></i>{{__('top_menu.expense_types')}}
                                  </a>
                              </li>


                              <li data-menu="">
                                  <a href="{{ route( 'manager.tank_card.index') }}" data-toggle="dropdown" class="dropdown-item">
                                      <i class="icon-card"></i>{{__('top_menu.tank_cards')}}
                                  </a>
                              </li>


                              <li data-menu="">
                                  <a href="{{ route( 'manager.tank_card_company.index') }}" data-toggle="dropdown" class="dropdown-item">
                                      <i class="icon-card"></i>{{__('top_menu.tank_card_companies')}}
                                  </a>
                              </li>


                          </ul>
                      </li>


                  </ul>

            </li>
