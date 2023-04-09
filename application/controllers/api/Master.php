<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Master extends CI_Controller
{
    // construct
    public function __construct()
    {
        parent::__construct();
        $this->load->model(['M_admin', 'M_master']);

        // cek apakah user sudah login
        if ($this->session->userdata('logged_in') == false || !$this->session->userdata('logged_in')) {
            if (!empty($_SERVER['QUERY_STRING'])) {
                $uri = uri_string() . '?' . $_SERVER['QUERY_STRING'];
            } else {
                $uri = uri_string();
            }
            $this->session->set_userdata('redirect', $uri);
            $this->session->set_flashdata('notif_warning', "Harap login untuk melanjutkan");
            redirect('sign-in');
        }

        if ($this->session->userdata('role') > 1) {
            $this->session->set_flashdata('warning', "Anda tidak memiliki akses pada halaman ini");
            redirect(base_url());
        }
    }

    public function saveKategori()
    {
        if ($this->M_master->saveKategori() == true) {
            $this->session->set_flashdata('notif_success', 'Berhasil menyimpan kategori');
            redirect($this->agent->referrer());
        } else {
            $this->session->set_flashdata('notif_warning', 'Terjadi kesalahan saat mencoba menyimpan kategori');
            redirect($this->agent->referrer());
        }
    }

    public function deleteKategori()
    {
        if ($this->M_master->deleteKategori() == true) {
            $this->session->set_flashdata('notif_success', 'Berhasil menghapus kategori');
            redirect($this->agent->referrer());
        } else {
            $this->session->set_flashdata('notif_warning', 'Terjadi kesalahan saat mencoba menghapus kategori');
            redirect($this->agent->referrer());
        }
    }

    public function addProduct()
    {
        if (isset($_FILES['image']) && $_FILES['image']['size'] > 0) {
            $date = date('m/Y');
            $path = "berkas/product/{$date}/";
            $upload = $this->uploader->uploadImage($_FILES['image'], $path);
            if ($upload == true) {
                if ($this->M_master->addProduct($upload['filename']) == true) {
                    $this->session->set_flashdata('notif_success', 'Berhasil menambahkan produk ');
                    redirect(site_url('master/produk'));
                } else {
                    $this->session->set_flashdata('notif_warning', 'Terjadi kesalahan saat mencoba menambahkan produk, harap coba lagi');
                    redirect($this->agent->referrer());
                }
            } else {
                $this->session->set_flashdata('notif_warning', $upload['message']);
                redirect($this->agent->referrer());
            }
        } else {
            if ($this->M_master->addProduct() == true) {
                $this->session->set_flashdata('notif_success', 'Berhasil menambahkan produk ');
                redirect(site_url('master/produk'));
            } else {
                $this->session->set_flashdata('notif_warning', 'Terjadi kesalahan saat mencoba menambahkan produk, harap coba lagi');
                redirect($this->agent->referrer());
            }
        }
    }

    public function editProduct()
    {
        if (isset($_FILES['image']) && $_FILES['image']['size'] > 0) {
            $date = date('m/Y');
            $path = "berkas/product/{$date}/";
            $upload = $this->uploader->uploadImage($_FILES['image'], $path);
            if ($upload == true) {
                if ($this->M_master->editProduct($upload['filename']) == true) {
                    $this->session->set_flashdata('notif_success', 'Berhasil mengubah produk ');
                    redirect(site_url('master/produk'));
                } else {
                    $this->session->set_flashdata('notif_warning', 'Terjadi kesalahan saat mencoba mengubah produk, harap coba lagi');
                    redirect($this->agent->referrer());
                }
            } else {
                $this->session->set_flashdata('notif_warning', $upload['message']);
                redirect($this->agent->referrer());
            }
        } else {
            if ($this->M_master->editProduct() == true) {
                $this->session->set_flashdata('notif_success', 'Berhasil mengubah produk ');
                redirect(site_url('master/produk'));
            } else {
                $this->session->set_flashdata('notif_warning', 'Terjadi kesalahan saat mencoba mengubah produk, harap coba lagi');
                redirect($this->agent->referrer());
            }
        }
    }

    public function deleteProduct()
    {
        if ($this->M_master->deleteProduct() == true) {
            $this->session->set_flashdata('notif_success', 'Berhasil menghapus produk ');
            redirect(site_url('master/produk'));
        } else {
            $this->session->set_flashdata('notif_warning', 'Terjadi kesalahan saat mencoba menghapus produk, harap coba lagi');
            redirect($this->agent->referrer());
        }
    }

    public function aktifProduct()
    {
        if ($this->M_master->aktifProduct() == true) {
            $this->session->set_flashdata('notif_success', 'Berhasil mengaktifkan produk ');
            redirect(site_url('master/produk'));
        } else {
            $this->session->set_flashdata('notif_warning', 'Terjadi kesalahan saat mencoba mengaktifkan produk, harap coba lagi');
            redirect($this->agent->referrer());
        }
    }

    public function nonaktifProduct()
    {
        if ($this->M_master->nonaktifProduct() == true) {
            $this->session->set_flashdata('notif_success', 'Berhasil menonaktifkan produk ');
            redirect(site_url('master/produk'));
        } else {
            $this->session->set_flashdata('notif_warning', 'Terjadi kesalahan saat mencoba menonaktifkan produk, harap coba lagi');
            redirect($this->agent->referrer());
        }
    }

    public function savePromo()
    {
        if (isset($_FILES['image']) && $_FILES['image']['size'] > 0) {
            $date = date('m/Y');
            $path = "berkas/promo/{$date}/";
            $upload = $this->uploader->uploadImage($_FILES['image'], $path);
            if ($upload == true) {
                if ($this->M_master->savePromo($upload['filename']) == true) {
                    $this->session->set_flashdata('notif_success', 'Berhasil menambahkan promo ');
                    redirect(site_url('master/promo'));
                } else {
                    $this->session->set_flashdata('notif_warning', 'Terjadi kesalahan saat mencoba menambahkan promo, harap coba lagi');
                    redirect($this->agent->referrer());
                }
            } else {
                $this->session->set_flashdata('notif_warning', $upload['message']);
                redirect($this->agent->referrer());
            }
        } else {
            if ($this->M_master->savePromo() == true) {
                $this->session->set_flashdata('notif_success', 'Berhasil menambahkan promo ');
                redirect(site_url('master/promo'));
            } else {
                $this->session->set_flashdata('notif_warning', 'Terjadi kesalahan saat mencoba menambahkan promo, harap coba lagi');
                redirect($this->agent->referrer());
            }
        }
    }

    public function editPromo()
    {
        if (isset($_FILES['image']) && $_FILES['image']['size'] > 0) {
            $date = date('m/Y');
            $path = "berkas/promo/{$date}/";
            $upload = $this->uploader->uploadImage($_FILES['image'], $path);
            if ($upload == true) {
				if ($this->M_master->editPromo($upload['filename']) == true) {
					$this->session->set_flashdata('notif_success', 'Berhasil mengubah promo ');
					redirect(site_url('master/promo'));
				} else {
					$this->session->set_flashdata('notif_warning', 'Terjadi kesalahan saat mencoba mengubah promo, harap coba lagi');
					redirect($this->agent->referrer());
				}
            } else {
                $this->session->set_flashdata('notif_warning', $upload['message']);
                redirect($this->agent->referrer());
            }
        } else {
			if ($this->M_master->editPromo() == true) {
				$this->session->set_flashdata('notif_success', 'Berhasil mengubah promo ');
				redirect(site_url('master/promo'));
			} else {
				$this->session->set_flashdata('notif_warning', 'Terjadi kesalahan saat mencoba mengubah promo, harap coba lagi');
				redirect($this->agent->referrer());
			}
        }
    }

    public function deletePromo()
    {
        if ($this->M_master->deletePromo() == true) {
            $this->session->set_flashdata('notif_success', 'Berhasil menghapus promo ');
            redirect(site_url('master/promo'));
        } else {
            $this->session->set_flashdata('notif_warning', 'Terjadi kesalahan saat mencoba menghapus promo, harap coba lagi');
            redirect($this->agent->referrer());
        }
    }

    public function saveMetode()
    {
        if (isset($_FILES['image']) && $_FILES['image']['size'] > 0) {
            $date = date('m/Y');
            $path = "berkas/metode/{$date}/";
            $upload = $this->uploader->uploadImage($_FILES['image'], $path);
            if ($upload == true) {
                if ($this->M_master->saveMetode($upload['filename']) == true) {
                    $this->session->set_flashdata('notif_success', 'Berhasil menyimpan metode');
                    redirect($this->agent->referrer());
                } else {
                    $this->session->set_flashdata('notif_warning', 'Terjadi kesalahan saat mencoba menyimpan metode');
                    redirect($this->agent->referrer());
                }
            } else {
                $this->session->set_flashdata('notif_warning', $upload['message']);
                redirect($this->agent->referrer());
            }
        } else {
            if ($this->M_master->saveMetode() == true) {
                $this->session->set_flashdata('notif_success', 'Berhasil menyimpan metode');
                redirect($this->agent->referrer());
            } else {
                $this->session->set_flashdata('notif_warning', 'Terjadi kesalahan saat mencoba menyimpan metode');
                redirect($this->agent->referrer());
            }
        }
    }

    public function deleteMetode()
    {
        if ($this->M_master->deleteMetode() == true) {
            $this->session->set_flashdata('notif_success', 'Berhasil menghapus metode');
            redirect($this->agent->referrer());
        } else {
            $this->session->set_flashdata('notif_warning', 'Terjadi kesalahan saat mencoba menghapus metode');
            redirect($this->agent->referrer());
        }
    }

    public function saveWithdraw()
    {
        if (isset($_FILES['image']) && $_FILES['image']['size'] > 0) {
            $date = date('m/Y');
            $path = "berkas/withdraw/{$date}/";
            $upload = $this->uploader->uploadImage($_FILES['image'], $path);
            if ($upload == true) {
                if ($this->M_master->saveWithdraw($upload['filename']) == true) {
                    $this->session->set_flashdata('notif_success', 'Berhasil menyimpan withdraw');
                    redirect($this->agent->referrer());
                } else {
                    $this->session->set_flashdata('notif_warning', 'Terjadi kesalahan saat mencoba menyimpan withdraw');
                    redirect($this->agent->referrer());
                }
            } else {
                $this->session->set_flashdata('notif_warning', $upload['message']);
                redirect($this->agent->referrer());
            }
        } else {
            if ($this->M_master->saveWithdraw() == true) {
                $this->session->set_flashdata('notif_success', 'Berhasil menyimpan withdraw');
                redirect($this->agent->referrer());
            } else {
                $this->session->set_flashdata('notif_warning', 'Terjadi kesalahan saat mencoba menyimpan withdraw');
                redirect($this->agent->referrer());
            }
        }
    }

    public function deleteWithdraw()
    {
        if ($this->M_master->deleteWithdraw() == true) {
            $this->session->set_flashdata('notif_success', 'Berhasil menghapus withdraw');
            redirect($this->agent->referrer());
        } else {
            $this->session->set_flashdata('notif_warning', 'Terjadi kesalahan saat mencoba menghapus withdraw');
            redirect($this->agent->referrer());
        }
    }

    public function saveBlockchain()
    {
        if ($this->M_master->saveBlockchain() == true) {
            $this->session->set_flashdata('notif_success', 'Berhasil menyimpan blockchain');
            redirect($this->agent->referrer());
        } else {
            $this->session->set_flashdata('notif_warning', 'Terjadi kesalahan saat mencoba menyimpan blockchain');
            redirect($this->agent->referrer());
        }
    }

    public function deleteBlockchain()
    {
        if ($this->M_master->deleteBlockchain() == true) {
            $this->session->set_flashdata('notif_success', 'Berhasil menghapus blockchain');
            redirect($this->agent->referrer());
        } else {
            $this->session->set_flashdata('notif_warning', 'Terjadi kesalahan saat mencoba menghapus blockchain');
            redirect($this->agent->referrer());
        }
    }

    public function setPriceProduct()
    {
        if ($this->M_master->setPriceProduct() == true) {
            $this->session->set_flashdata('notif_success', 'Berhasil menyimpan rate harga product');
            redirect($this->agent->referrer());
        } else {
            $this->session->set_flashdata('notif_warning', 'Terjadi kesalahan saat mencoba menyimpan rate harga product');
            redirect($this->agent->referrer());
        }
    }

    public function saveVcc()
    {
        if ($this->M_master->saveVcc() == true) {
            $this->session->set_flashdata('notif_success', 'Berhasil menyimpan vcc');
            redirect($this->agent->referrer());
        } else {
            $this->session->set_flashdata('notif_warning', 'Terjadi kesalahan saat mencoba menyimpan vcc');
            redirect($this->agent->referrer());
        }
    }

    public function deleteVcc()
    {
        if ($this->M_master->deleteVcc() == true) {
            $this->session->set_flashdata('notif_success', 'Berhasil menghapus vcc');
            redirect($this->agent->referrer());
        } else {
            $this->session->set_flashdata('notif_warning', 'Terjadi kesalahan saat mencoba menghapus vcc');
            redirect($this->agent->referrer());
        }
    }
}
