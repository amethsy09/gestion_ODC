<!DOCTYPE html>
<html lang="fr" data-theme="corporate">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Apprenants</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/daisyui@1.14.2/dist/full.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="p-4 bg-gray-50">
    <div class="container mx-auto">
        <h1 class="text-2xl font-bold mb-6">1. Liste des Apprenants</h1>
        
        <div class="bg-white rounded-lg shadow p-6 mb-6">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4">
                <div>
                    <h2 class="text-xl font-semibold">Gestion des Apprenants</h2>
                    <p class="text-sm text-gray-500">Affiche la liste des apprenants de la promotion en cours</p>
                </div>
                
                <button class="btn btn-primary">
                    <i class="fas fa-plus mr-2"></i>Ajouter un Apprenant
                </button>
            </div>
            
            <div class="flex flex-col md:flex-row gap-4 mb-6">
                <div class="flex-1">
                    <div class="relative">
                        <input type="text" placeholder="Rechercher par matricule, nom ou référentiel..." class="input input-bordered w-full">
                        <button class="absolute right-3 top-3">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </div>
                
                <div class="flex gap-4">
                    <select class="select select-bordered">
                        <option disabled selected>Filtre par classe</option>
                        <option>DEV WEB/MOBILE</option>
                        <option>REF_DIG</option>
                        <option>DEV DATA</option>
                        <option>AWS</option>
                        <option>MARKETING</option>
                    </select>
                    
                    <select class="select select-bordered">
                        <option disabled selected>Filtre par statut</option>
                        <option>Actif</option>
                        <option>Inactif</option>
                        <option>En pause</option>
                    </select>
                    
                    <div class="dropdown dropdown-end">
                        <button tabindex="0" class="btn btn-outline">
                            <i class="fas fa-download mr-2"></i>Exporter
                        </button>
                        <ul tabindex="0" class="dropdown-content menu p-2 shadow bg-base-100 rounded-box w-52">
                            <li><a><i class="fas fa-file-pdf mr-2"></i>PDF</a></li>
                            <li><a><i class="fas fa-file-excel mr-2"></i>Excel</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            
            <div class="divider my-2"></div>
            
            <div class="overflow-x-auto">
                <table class="table w-full">
                    <thead>
                        <tr>
                            <th>Photo</th>
                            <th>Matricule</th>
                            <th>Nom Complet</th>
                            <th>Adresse</th>
                            <th>Téléphone</th>
                            <th>Référentiel</th>
                            <th>Statut</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Exemple de ligne avec menu déroulant pour les actions -->
                        <tr>
                            <td>
                                <div class="avatar placeholder">
                                    <div class="bg-neutral-focus text-neutral-content rounded-full w-8">
                                        <span class="text-xs">SM</span>
                                    </div>
                                </div>
                            </td>
                            <td>1058275</td>
                            <td>Syntho-Ma-AmmacRbo</td>
                            <td>Steps Leont é-visit 0500 Daux, Stvégel</td>
                            <td>780935AA</td>
                            <td>
                                <span class="badge badge-primary">DEV WEB/MOBILE</span>
                            </td>
                            <td>
                                <span class="badge badge-success">Actif</span>
                            </td>
                            <td>
                                <div class="dropdown dropdown-left">
                                    <button tabindex="0" class="btn btn-xs">Actions</button>
                                    <ul tabindex="0" class="dropdown-content menu p-2 shadow bg-base-100 rounded-box w-52">
                                        <li><a><i class="fas fa-eye mr-2"></i>Voir détails</a></li>
                                        <li><a><i class="fas fa-exchange-alt mr-2"></i>Changer statut</a></li>
                                        <li><a class="text-red-500"><i class="fas fa-trash mr-2"></i>Supprimer</a></li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                        
                        <!-- Autres lignes -->
                        <tr>
                            <td>
                                <div class="avatar placeholder">
                                    <div class="bg-neutral-focus text-neutral-content rounded-full w-8">
                                        <span class="text-xs">MO</span>
                                    </div>
                                </div>
                            </td>
                            <td>1058276</td>
                            <td>Marxeba Oaya</td>
                            <td>Max Weber l'al Daux, Stvégel</td>
                            <td>78102623</td>
                            <td>
                                <span class="badge badge-secondary">REF_DIG</span>
                            </td>
                            <td>
                                <span class="badge badge-success">Actif</span>
                            </td>
                            <td>
                                <div class="dropdown dropdown-left">
                                    <button tabindex="0" class="btn btn-xs">Actions</button>
                                    <ul tabindex="0" class="dropdown-content menu p-2 shadow bg-base-100 rounded-box w-52">
                                        <li><a><i class="fas fa-eye mr-2"></i>Voir détails</a></li>
                                        <li><a><i class="fas fa-exchange-alt mr-2"></i>Changer statut</a></li>
                                        <li><a class="text-red-500"><i class="fas fa-trash mr-2"></i>Supprimer</a></li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                        
                        <tr>
                            <td>
                                <div class="avatar placeholder">
                                    <div class="bg-neutral-focus text-neutral-content rounded-full w-8">
                                        <span class="text-xs">NU</span>
                                    </div>
                                </div>
                            </td>
                            <td>1058277</td>
                            <td>Nologu u</td>
                            <td>Steps Daniel Daux, Stvégel</td>
                            <td>784559200</td>
                            <td>
                                <span class="badge badge-accent">DEV DATA</span>
                            </td>
                            <td>
                                <span class="badge badge-warning">En pause</span>
                            </td>
                            <td>
                                <div class="dropdown dropdown-left">
                                    <button tabindex="0" class="btn btn-xs">Actions</button>
                                    <ul tabindex="0" class="dropdown-content menu p-2 shadow bg-base-100 rounded-box w-52">
                                        <li><a><i class="fas fa-eye mr-2"></i>Voir détails</a></li>
                                        <li><a><i class="fas fa-exchange-alt mr-2"></i>Changer statut</a></li>
                                        <li><a class="text-red-500"><i class="fas fa-trash mr-2"></i>Supprimer</a></li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            
            <div class="divider my-2"></div>
            
            <div class="flex flex-col md:flex-row justify-between items-center gap-4">
                <div class="flex items-center">
                    <span class="text-sm mr-2">Apprenants par page</span>
                    <select class="select select-bordered select-sm">
                        <option selected>10</option>
                        <option>25</option>
                        <option>50</option>
                        <option>100</option>
                    </select>
                </div>
                
                <div class="flex flex-col md:flex-row items-center gap-4">
                    <span class="text-sm">1 à 10 apprenants sur 142</span>
                    <div class="btn-group">
                        <button class="btn btn-sm btn-disabled">«</button>
                        <button class="btn btn-sm btn-active">1</button>
                        <button class="btn btn-sm">2</button>
                        <button class="btn btn-sm">3</button>
                        <button class="btn btn-sm">...</button>
                        <button class="btn btn-sm">15</button>
                        <button class="btn btn-sm">»</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal pour ajouter un apprenant -->
<input type="checkbox" id="modal-ajout" class="modal-toggle" />
<div class="modal">
  <div class="modal-box">
    <h3 class="font-bold text-lg">Ajouter un nouvel apprenant</h3>
    <form id="form-ajout-apprenant" class="mt-4 space-y-4">
      <div class="form-control">
        <label class="label">
          <span class="label-text">Matricule</span>
        </label>
        <input type="text" name="matricule" placeholder="Matricule" class="input input-bordered w-full" required>
      </div>
      <div class="form-control">
        <label class="label">
          <span class="label-text">Nom Complet</span>
        </label>
        <input type="text" name="nomComplet" placeholder="Nom complet" class="input input-bordered w-full" required>
      </div>
      <!-- Ajoutez les autres champs nécessaires -->
      <div class="modal-action">
        <button type="submit" class="btn btn-primary">Ajouter</button>
        <label for="modal-ajout" class="btn">Annuler</label>
      </div>
    </form>
  </div>
</div>
    </div>
